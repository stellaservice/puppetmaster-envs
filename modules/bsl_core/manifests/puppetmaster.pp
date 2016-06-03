class bsl_core::puppetmaster {
  if $::osfamily == 'Debian' {
    include apt
  }

  include 'java'
  include 'ruby'
  include 'python'

  if defined('bsl_bootstrap') {
    include 'bsl_bootstrap::puppetmaster::setup'
    include 'bsl_bootstrap::puppetmaster::done'
  }
  else {
    notify { 'bsl_bootstrap not available for bsl_core::puppetmaster': }
    err('bsl_bootstrap not available for bsl_core::puppetmaster')
  }

  if defined('bsl_infrastructure::aws') {
    include 'bsl_infrastructure::aws'
  }
  else {
    notify { 'bsl_infrastructure not available for bsl_core::puppetmaster': }
    err('bsl_infrastructure not available for bsl_core::puppetmaster')
  }
}
