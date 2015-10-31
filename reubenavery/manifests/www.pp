class reubenavery::www {
  class { '::apache':
    
  }

  Class['apache']->anchor { '::reubenavery:www': }
}