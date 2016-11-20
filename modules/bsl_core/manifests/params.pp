class bsl_core::params {
  case $::osfamily {
    'Debian': {
      $service_acct = 'admin'
    }
    'Ubuntu': {
      $service_acct = 'ubuntu'
    }
    'RedHat': {
      case $::operatingsystem {
        'CentOS': {
          $service_acct = 'centos'
        }
      }
    }
    'Linux': {
      case $::operatingsystem {
        'Amazon': {
          $service_acct = 'ec2-user'
        }
      }
    }
  }

  $rancher_port = 9090
}
