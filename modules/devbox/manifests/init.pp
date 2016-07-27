class devbox {
  notify { "## hello from devbox!": }
  include apt::update

  package { 'rdebug-ide':
    ensure => installed,
  }
}
