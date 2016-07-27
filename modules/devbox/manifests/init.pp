class devbox {
  notify { "## hello from devbox!": }

  include apt
  include '::rvm'
  rvm::system_user { 'ravery': create => false }

  rvm_system_ruby {
    'ruby-1.9':
      ensure      => 'present',
      default_use => true,
      build_opts  => ['--binary'];
    'ruby-2.1':
      ensure      => 'present',
      default_use => true,
      build_opts  => ['--binary']
  }

  class { 'hostname':
    hostname => 'devbox',
    domain => 'bitswarm.io'
  }

  # package { 'rdebug-ide':
  #   ensure => installed,
  # }
}
