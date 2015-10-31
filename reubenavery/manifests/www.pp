class reubenavery::www {
  class { 'wordpress':
    wp_owner    => 'wordpress',
    wp_group    => 'wordpress',
    db_user     => 'wordpress',
    db_password => 'hvyH(S%t(\"0\"16',
  }

}