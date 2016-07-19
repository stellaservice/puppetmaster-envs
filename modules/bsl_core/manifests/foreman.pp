class bsl_core::foreman(
  $manage_infrastructure = 'false',
) {
  notify { '## hello from CORE (environments/core) bsl_core::foreman': }

  if $::osfamily == 'Debian' {
    include apt
  }

  # Relying on configuration via Hiera
  include '::bsl_puppet'

  if str2bool($manage_infrastructure) {
    notify { "## managing infrastructure": }

    if defined('bsl_infrastructure') {
      include 'bsl_infrastructure'
    }
    else {
      notify { 'bsl_infrastructure not available for bsl_core::puppetmaster': }
      err('bsl_infrastructure not available for bsl_core::puppetmaster')
    }
  }
}
