class bsl_core::puppetmaster(
  $manage_infrastructure = 'false',
) {
  notify { '## hello from CORE (environments/core) bsl_core::puppetmaster': }

  if $::osfamily == 'Debian' {
    include apt
  }

  include 'java'
  include 'ruby'
  include 'python'

  if defined('::bsl_bootstrap') {
    notify { 'bsl_bootstrap available': }
    include '::bsl_bootstrap::puppetmaster::setup'
    # include '::bsl_bootstrap::puppetmaster::done'
  }
  else {
    notify { 'bsl_bootstrap not available for bsl_core::puppetmaster': }
    err('bsl_bootstrap not available for bsl_core::puppetmaster')
  }

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
