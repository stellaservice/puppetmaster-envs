require_relative '../../../puppet_x/puppetlabs/gms.rb'
require 'puppet/type/gms_webhook'
require 'json'

Puppet::Type.type(:gms_webhook).provide(:github, :parent => PuppetX::Puppetlabs::Gms) do

  defaultfor :github => :exist
  defaultfor :feature => :posix

  mk_resource_methods

  def gms_server
    PuppetX::Puppetlabs::Gms::gms_server
  end

  def calling_method
    # Get calling method and clean it up for good reporting
    cm = String.new
    cm = caller[0].split(" ").last
    cm.tr!('\'', '')
    cm.tr!('\`','')
    cm
  end

  def self.instances
    # Puppet.notice("def self.instances")

    instances = []

    repos_url = "#{gms_server}/user/repos"

    repos = get(repos_url)

    webhooks = Array.new

    $hooks = Hash.new

    repos.each do |r|

      hooks_url = r['hooks_url']

      hook_objs = get(hooks_url)

      hook_objs.each do |h|
        $hooks[h['id']] = h['url'] if h.class == Hash && h[:message].nil?
        webhooks << h if h.class == Hash && h[:message].nil?
      end

    end

    webhooks.each do |webhook|

      webhook['config']['insecure_ssl'] = :true   if webhook['config']['insecure_ssl'] && webhook['config']['insecure_ssl'] == '1'
      webhook['config']['insecure_ssl'] = :false  if webhook['config']['insecure_ssl'] && webhook['config']['insecure_ssl'] == '0'

      # Build project_name parameter
      pn_array = webhook['url'].split('/')
      pn = pn_array[4] + '/' + pn_array[5]

      create = {
        ensure:                :present,
        name:                  webhook['name'] + '_' + webhook['id'].to_s,
        id:                    webhook['id'],
        web:                   webhook['web'],
        rest_url:              webhook['url'],
        test_url:              webhook['test_url'],
        ping_url:              webhook['ping_url'],
        project_name:          pn,
        #config:                webhook['config'],
        active:                webhook['active'],
        events:                webhook['events'],
        last_response_code:    webhook['last_response']['code'],
        last_response_status:  webhook['last_response']['status'],
        last_response_message: webhook['last_response']['message'],
        updated_at:            webhook['updated_at'],
        created_at:            webhook['created_at'],
        secret:                webhook['config']['secret'],
        disable_ssl_verify:    webhook['config']['insecure_ssl'],
        content_type:          webhook['config']['content_type'],
        webhook_url:           webhook['config']['url']
      }

      instances << new(create)

    end

    instances
  end

  def self.prefetch(resources)
    @project_name = resources[resources.keys.first].value('project_name')
    @token = resources[resources.keys.first].value('token')

    # Puppet.notice("def prefetch")

    $webhooks = instances

    resources.keys.each do |name|
      if provider = $webhooks.find { |wh| wh.name == name }
        resources[name].provider = provider
      end
    end
  end

  def message(object)
    Puppet.notice("def message")
    # Allows us to pass in resources and get all the attributes out
    # in the form of a hash.

    message = object.to_hash

    message[:content_type] = 'json' if message[:content_type].nil?

    map = {
      :'content_type'       => :content_type,
      :'disable_ssl_verify' => :insecure_ssl,
      :'webhook_url'        => :url,
    }

    if message[:active].nil? && (message[:ensure] == :present || resource[:ensure] == :present)
      message[:active] = true
    else
      message[:active] = false
    end

    message[:events] = ['push'] if message[:events].nil?

    # For now, we will only support setting up 'web' webhooks.  GitHub has a
    # list of many more types of webhooks that can be supported:
    # https://api.github.com/hooks
    message[:name] = 'web'

    message = nest_hash_keys(map, :config, message)

    github_params = [:name, :config, :events, :active]

    message = clean_json(github_params, message)

    message = create_message(message)

    # Puppet.notice("message = #{message.inspect}")

    message.to_json
  end

  def get_webhook_id
    Puppet.notice("def get_webhook_id")

    $hooks.each_pair do |k,v|
      webhook = PuppetX::Puppetlabs::Gms.get(v)

      input_hash = JSON.parse(message(resource))

      if get_project_name == url_to_project_name(v) && input_hash['config']['url'] == webhook['config']['url'] && webhook['name'] =~ /^#{input_hash['name']}/
        Puppet.debug("github_gms_webook.get_webhook_id: Found match, returning #{k.to_s}")
        return k
      end
    end
    return nil
  end

  def exists?
    # Puppet.notice("def exists")

    return true if get_webhook_id

    @property_hash[:ensure] == :present
  end

  def flush
    # Puppet.notice ("def flush")

    if @property_hash == {}
      return nil
    end

    webhook_id = get_webhook_id

    patch_url = "#{gms_server}/repos/#{resource[:project_name].strip}/hooks/#{webhook_id}"

    github_params = ['name', 'config', 'events', 'active']

    input_hash = JSON.parse(message(@property_hash))

    # Need to compare between what returns from self.instances and what was
    # provided in Puppet DSL.  Since hash ordering can throw off whatever
    # creates @property_hash in the flush method, we have to take matters
    # into our own hands and therefore check for any differences.

    # matches = 0
    #
    # $webhooks.each do |wh|
    #   if wh.id == webhook_id
    #     github_params.each do |g|
    #       wh_result = wh.send(g)
    #       in_result = input_hash[g]
    #
    #       wh_result = wh_result.to_a if wh_result.class == Hash
    #       in_result = in_result.to_a if in_result.class == Hash
    #
    #       if g == 'name'
    #         if wh_result =~ /^#{in_result}/
    #           matches += 1
    #         end
    #       elsif in_result == wh_result
    #         matches += 1
    #       else
    #         # Puppet.notice("diff = #{in_result} vs #{wh_result}")
    #       end
    #     end
    #   end
    # end
    #
    # # Puppet.notice("matches = #{matches.to_s}")
    #
    # if matches == github_params.size
    #   @property_hash.clear
    # end

    if @property_hash != {}

      Puppet.notice ("FLUSH: @property_hash = #{@property_hash.inspect}")

      # Puppet.notice("Flush is RUNNING!")

      begin
        response = PuppetX::Puppetlabs::Gms.patch(patch_url, message(@property_hash))

        if (response.class != Net::HTTPOK)
          raise(Puppet::Error, "github_webhook::#{calling_method}: #{response.inspect}")
        end
      rescue Exception => e
        raise(Puppet::Error, "github_webhook::#{calling_method}: #{e.message}")
      end

      return response
    end
  end

  def create
    # Puppet.notice("def create")

    post_url = "#{self.gms_server}/repos/#{resource[:project_name].strip}/hooks"

    begin
      response = PuppetX::Puppetlabs::Gms.post(post_url, message(resource))

      if (response.class == Net::HTTPCreated)
        # We clear the hash here to stop flush from triggering.
        @property_hash.clear

        return true
      else
        raise(Puppet::Error, "gms_github_webhook::#{calling_method}: #{response.inspect}")
        return false
      end
    rescue Exception => e
      raise(Puppet::Error, "gms_github_webhook::#{calling_method}: #{e.message}")
      return false
    end

  end


  def destroy
    # Puppet.notice("def destroy")

    webhook_id = get_webhook_id

    unless webhook_id.nil?
      destroy_url = "#{gms_server}/repos/#{resource[:project_name].strip}/hooks/#{webhook_id}"

      begin
        response = PuppetX::Puppetlabs::Gms.delete(destroy_url)

        if (response.class == Net::HTTPNoContent)
          return true
        else
          raise(Puppet::Error, "github_webhook::#{calling_method}: #{response.inspect}")
        end
      rescue Exception => e
        raise(Puppet::Error, "github_webhook::#{calling_method}: #{e.message}")
      end

    end
  end

end
