class bsl_core::puppetmaster {
  if $::osfamily == 'Debian' {
    include apt
  }

  include 'java'
  include 'ruby'
  include 'python'

  include 'bsl_bootstrap::puppetmaster::setup'
  include 'bsl_bootstrap::puppetmaster::done'

  include 'bsl_infrastructure::aws'
}