class bsl_core::params {
  case $::osfamily {
    'Debian': {
      $service_acct = 'admin'
    }
    'Ubuntu': {
      $service_acct = 'ubuntu'
    }
  }
}
