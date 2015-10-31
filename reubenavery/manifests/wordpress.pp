class reubenavery::wordpress(
  $home = '/srv/reubenavery-www/wordpress',
) {
  include reubenavery
  include reubenavery::www

  class { '::wordpress':
    install_dir => $home,
    wp_owner    => $reubenavery::www_user,
    wp_group    => $reubenavery::www_user,
    db_user     => $reubenavery::db_user,
    db_password => $reubenavery::db_pass,
    require     => Class['reubenavery::www'],
  }

}