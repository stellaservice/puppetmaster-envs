require 'spec_helper'

describe 'puppet::agent' do
  on_supported_os.each do |os, os_facts|
    next if only_test_os() and not only_test_os.include?(os)
    next if exclude_test_os() and exclude_test_os.include?(os)
    context "on #{os}" do
      let (:default_facts) do
        os_facts.merge({
          :clientcert => 'puppetmaster.example.com',
          :concat_basedir => '/nonexistant',
          :fqdn => 'puppetmaster.example.com',
          :puppetversion => Puppet.version,
      }) end

      if Puppet.version < '4.0'
        client_package = 'puppet'
        confdir        = '/etc/puppet'
        if os_facts[:osfamily] == 'FreeBSD'
          client_package = 'puppet38'
          confdir        = '/usr/local/etc/puppet'
        end
        additional_facts = {}
      else
        client_package = 'puppet-agent'
        confdir        = '/etc/puppetlabs/puppet'
        additional_facts = {:rubysitedir => '/opt/puppetlabs/puppet/lib/ruby/site_ruby/2.1.0'}
        if os_facts[:osfamily] == 'FreeBSD'
          client_package = 'puppet4'
          confdir        = '/usr/local/etc/puppet'
          additional_facts = {}
        end
      end

      let :facts do
        default_facts.merge(additional_facts)
      end

      describe 'with no custom parameters' do
        let :pre_condition do
          "class {'puppet': agent => true}"
        end
        it { should contain_class('puppet::agent::install') }
        it { should contain_class('puppet::agent::config') }
        it { should contain_class('puppet::agent::service') }
        it { should contain_file(confdir).with_ensure('directory') }
        it { should contain_concat("#{confdir}/puppet.conf") }
        it { should contain_package(client_package).with_ensure('present') }
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
            with_content(/^\[agent\]/).
            with({})
        end

        it do
          should contain_concat__fragment('puppet.conf+20-agent').
                     with_content(/server.*puppetmaster\.example\.com/)
        end

        it do
          should contain_concat__fragment('puppet.conf+20-agent').
            without_content(/prerun_command\s*=/)
        end

        it do
          should contain_concat__fragment('puppet.conf+20-agent').
            without_content(/postrun_command\s*=/)
        end
      end

      describe 'puppetmaster parameter overrides server fqdn' do
        let(:pre_condition) { "class {'puppet': agent => true, puppetmaster => 'mymaster.example.com'}" }
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
                     with_content(/server.*mymaster\.example\.com/)
        end
      end

      describe 'global puppetmaster overrides fqdn' do
        let(:pre_condition) { "class {'puppet': agent => true}" }
        let :facts do
          default_facts.merge({:puppetmaster => 'mymaster.example.com'})
        end
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
                     with_content(/server.*mymaster\.example\.com/)
        end
      end

      describe 'puppetmaster parameter overrides global puppetmaster' do
        let(:pre_condition) { "class {'puppet': agent => true, puppetmaster => 'mymaster.example.com'}" }
        let :facts do
          default_facts.merge({:puppetmaster => 'global.example.com'})
        end
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
                     with_content(/server.*mymaster\.example\.com/)
        end
      end

      describe 'use_srv_records removes server setting' do
        let(:pre_condition) { "class {'puppet': agent => true, use_srv_records => true}" }
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
                     without_content(/server\s*=/)
        end
      end

      describe 'set prerun_command will be included in config' do
        let(:pre_condition) { "class {'puppet': agent => true, prerun_command => '/my/prerun'}" }
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
            with_content(/prerun_command.*\/my\/prerun/)
        end
      end

      describe 'set postrun_command will be included in config' do
        let(:pre_condition) { "class {'puppet': agent => true, postrun_command => '/my/postrun'}" }
        it do
          should contain_concat__fragment('puppet.conf+20-agent').
            with_content(/postrun_command.*\/my\/postrun/)
        end
      end

      describe 'with additional settings' do
        let :pre_condition do
          "class {'puppet':
              agent_additional_settings => {ignoreschedules => true},
           }"
        end

        it 'should configure puppet.conf' do
          should contain_concat__fragment('puppet.conf+20-agent').
            with_content(/^\s+ignoreschedules\s+= true$/).
            with({}) # So we can use a trailing dot on each with_content line
        end
      end

    end
  end
end

