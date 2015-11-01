class reubenavery::www::sites::reubenavery(
  $home = '/srv/reubenavery-www',
  $docroot = "/srv/reubenavery-www/wordpress",
  $www_user = 'reubenavery-www',
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
) inherits reubenavery::params {
  include reubenavery::www

  user { $www_user:
    ensure     => present,
    home       => $home,
    managehome => true,
  }
  ->
  group { $www_user:
    ensure => present,
  }
  ->
  file { $docroot:
    ensure => directory,
    owner  => $www_user,
    group  => $www_user,
  }
  ->
  class { '::wordpress':
    install_dir => $docroot,
    wp_owner    => $www_user,
    wp_group    => $www_user,
    db_user     => $db_user,
    db_password => $db_pass,
  }

  apache::vhost { 'reubenavery-www':
    servername          => 'www.reubenavery.com',
    serveraliases       => ['reubenavery.com'],
    port                => '80',
    docroot             => $docroot,
    override            => 'all',
  }

  ssh_authorized_key { 'reubenavery-www-general':
    user => $www_user,
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAAAgQDruHUiFjNbJfnmVeuU/B+Udv139ngjN1+qsXcDQFpVc4fGRWUG+CCAi9S+Tx/W/62YqU1qK2uJRzrpeyO+aEJorjWO7ozNn23alsnTWwuYC+YhPgQU4DkMe/5pcukee5p0I2qZrUxNtGcLmoUjvxNmbR5egVos9uhX0xnhBCqGBQ==',
  }
}