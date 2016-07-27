class devbox {
  include apt
  include '::rvm'
  rvm::system_user { 'ravery': create => false }

  rvm_system_ruby { 'ruby-2.1.7':
      ensure      => 'present',
      default_use => true,
  }

  class { 'hostname':
    hostname => 'devbox',
    domain => 'bitswarm.io'
  }

  # package { 'rdebug-ide':
  #   ensure => installed,
  # }
}
