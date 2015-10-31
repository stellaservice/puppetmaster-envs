class reubenavery::www {
  include reubenavery

  class { '::apache':
    default_vhost => false,
  }

  Class['apache']->anchor { '::reubenavery:www': }
}