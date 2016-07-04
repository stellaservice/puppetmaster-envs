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

  $iam_arn = $ec2_metadata['iam']['info']['InstanceProfileArn']
  $iam_profile = regsubst($iam_arn, '^.*\/', '')
  notify { $iam_arn: }
  notify { $iam_profile: }
}
