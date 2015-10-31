class reubenavery::www {
  class { '::apache':
    manage_user  => false,
    manage_group => false,
    user         => $reubenavery::www_user,
    group        => $reubenavery::www_user,
  }

  Class['apache']->anchor { '::reubenavery:www': }
}