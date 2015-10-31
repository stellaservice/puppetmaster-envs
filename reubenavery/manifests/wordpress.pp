class reubenavery::wordpress(
  $home = "${reubenavery::srv_home}/wordpress",
) inherits reubenavery {
  include reubenavery::www

  apache::vhost { 'reubenavery-www':
    port    => '80',
    docroot => $home,
  }

  class { '::wordpress':
    install_dir => $home,
    wp_owner    => $reubenavery::www_user,
    wp_group    => $reubenavery::www_user,
    db_user     => $reubenavery::db_user,
    db_password => $reubenavery::db_pass,
    require     => Class['reubenavery::www'],
  }
}