class bsl_core::puppetmaster(
  $manage_infrastructure = 'false',
  $aws_region = 'us-east-1'
) {
  if $::osfamily == 'Debian' {
    include apt
  }

  # Relying on configuration via Hiera
  include '::bsl_puppet'

  if str2bool($manage_infrastructure) {
    if defined('bsl_infrastructure') {
      include 'bsl_infrastructure'
    }
    else {
      err('bsl_infrastructure not available for bsl_core::puppetmaster')
    }
  }

  # Installing Amazon Simple Systems Management agent
  # class { '::ssm':
  #   region => $aws_region,
  # }
}
