class bsl_core::foreman(
  $manage_infrastructure = 'false',
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
      err('bsl_infrastructure not available for bsl_core::foreman')
    }
  }
}
