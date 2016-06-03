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
  
  if defined('bsl_infrastructure::aws') {
    include 'bsl_infrastructure::aws'
  }
}
