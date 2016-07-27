class devbox {
  notify { "## hello from devbox!": }

  include apt
  include '::rvm'
  rvm::system_user { 'ravery': create => false }

  class { 'hostname':
    hostname => 'devbox',
    domain => 'bitswarm.io'
  }

  # package { 'rdebug-ide':
  #   ensure => installed,
  # }
}
