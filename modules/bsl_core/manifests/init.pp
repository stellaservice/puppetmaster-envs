class bsl_core(
  $service_acct = $bsl_core::params::service_acct
) inherits bsl_core::params {

  class { 'ohmyzsh::config': theme_hostname_slug => '%M' }

  # for multiple users in one shot and set their shell to zsh
  ohmyzsh::install { 'root': set_sh => true, disable_auto_update => true }
  ohmyzsh::install { $service_acct: set_sh => true, disable_update_prompt => true }

  package { 'pygmentize':
    ensure => installed,
    provider => gem,
  }

  ohmyzsh::plugins { ['root', $service_acct]: plugins => ['gitfast', 'colorize'] }
  ohmyzsh::theme { ['root', $service_acct]: }

  if !empty($::ec2_metadata['iam']['info']) {
    $iam_info = parsejson($::ec2_metadata['iam']['info'])
    $iam_arn = $iam_info['InstanceProfileArn']
    $iam_profile_id = $iam_info['InstanceProfileId']
    $iam_profile_name = regsubst($iam_arn, '^.*\/', '')
    notify { "## iam profile arn: $iam_arn": }
    notify { "## iam profile id: $iam_profile_id": }
    notify { "## iam profile name: $iam_profile_name": }
    file { '/etc/facter/facts.d/bitswarm-ec2.yaml':
      ensure => absent,
      # content => template('bsl_core/bitswarm-ec2.yaml.erb')
    }
  }
  else {
    notify { "## iam profile not found in metadata: ${::ec2_metadata['iam']['info']}": }
  }

  hiera_include('classes')
}
