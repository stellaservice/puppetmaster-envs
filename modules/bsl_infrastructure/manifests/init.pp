# Class: bsl_infrastructure
# ===========================
#
# Full description of class bsl_infrastructure here.
#
# Parameters
# ----------
#
# Document parameters here.
#
# * `sample parameter`
# Explanation of what this parameter affects and what it defaults to.
# e.g. "Specify one or more upstream ntp servers as an array."
#
# Variables
# ----------
#
# Here you should define a list of variables that this module would require.
#
# * `sample variable`
#  Explanation of how this variable affects the function of this class and if
#  it has a default. e.g. "The parameter enc_ntp_servers must be set by the
#  External Node Classifier as a comma separated list of hostnames." (Note,
#  global variables should be avoided in favor of class parameters as
#  of Puppet 2.6.)
#
# Examples
# --------
#
# @example
#    class { 'bsl_infrastructure':
#      servers => [ 'pool.ntp.org', 'ntp.local.company.com' ],
#    }
#
# Authors
# -------
#
# Author Name <author@domain.com>
#
# Copyright
# ---------
#
# Copyright 2016 Your name here, unless otherwise noted.
#
class bsl_infrastructure(
  $providers = undef,
  $tenants = undef,
  $manage_providers = 'true',
  $manage_tenants = 'true',
) {
  include 'bsl_infrastructure::auth'

  if $providers and str2bool($manage_providers) {
    validate_hash($providers)
    create_resources('bsl_infrastructure::provider', $providers)
  }

  if $tenants and str2bool($manage_tenants) {
    validate_hash($tenants)
    create_resources('bsl_infrastructure::tenant', $tenants)
  }
}
