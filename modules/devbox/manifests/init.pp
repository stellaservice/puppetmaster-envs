class devbox {
  include apt::update

  package { 'rdebug-ide':
    ensure => installed,
  }
}
