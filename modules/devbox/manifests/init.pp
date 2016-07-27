class devbox {
  notify { "## hello from devbox!": }

  include apt


  class { 'hostname':
    hostname => 'devbox',
    domain => 'bitswarm.io'
  }

  package { 'rdebug-ide':
    ensure => installed,
  }
}
