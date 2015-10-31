class reubenavery::www {
  include apache

  Class['apache']->anchor { '::reubenavery:www': }
}