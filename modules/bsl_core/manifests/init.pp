class bsl_core(
  $service_acct = $bsl_core::params::service_acct
) inherits bsl_core::params {
  include '::awscli'
  include '::ec2tagfacts'
  include 'bsl_core::credstash'

  class { 'ohmyzsh::config': theme_hostname_slug => '%M' }

  # for multiple users in one shot and set their shell to zsh
  ohmyzsh::install { 'root': set_sh => true, disable_auto_update => true }
  ohmyzsh::install { $service_acct: set_sh => true, disable_update_prompt => true }

  package { 'pygmentize':
    ensure   => installed,
    provider => gem,
  }

  ohmyzsh::plugins { ['root', $service_acct]: plugins => ['gitfast', 'colorize'] }
  ohmyzsh::theme { ['root', $service_acct]: }

  $ec2_instance_id = $::ec2_metadata['instance-id']
  $puppetmaster_fqdn = hiera('puppetmaster', 'puppet')

  if !empty($::ec2_metadata['iam']['info']) {
    $iam_info = parsejson($::ec2_metadata['iam']['info'])
    $iam_arn = $iam_info['InstanceProfileArn']
    $iam_profile_id = $iam_info['InstanceProfileId']
    $iam_profile_name = regsubst($iam_arn, '^.*\/', '')
  }

  file { ['/etc/facter', '/etc/facter/facts.d']:
    ensure => directory,
  }

  file { '/etc/facter/facts.d/bitswarm-ec2.yaml':
    ensure  => file,
    content => template('bsl_core/bitswarm-ec2.yaml.erb'),
    require => File['/etc/facter/facts.d'],
  }

  if !empty($::ec2_tag_hostname) {
    class { 'hostname':
      hostname => $::ec2_tag_hostname,
      domain   => hiera('domain', $::domain),
    }
  }
}
