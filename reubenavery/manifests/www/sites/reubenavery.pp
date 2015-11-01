class reubenavery::www::sites::reubenavery(
  $home = '/srv/reubenavery-www',
  $docroot = "/srv/reubenavery-www/wordpress",
  $www_user = 'wordpress',
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
) inherits reubenavery::params {
  include reubenavery::www

  user { $www_user:
    ensure     => present,
    home       => $home,
    managehome => true,
  }

  group { $www_user:
    ensure => present,
  }

  class { '::wordpress':
    install_dir => $docroot,
    wp_owner    => $www_user,
    wp_group    => $www_user,
    db_user     => $db_user,
    db_password => $db_pass,
    require     => User[$www_user],
  }

  apache::vhost { 'reubenavery-www':
    port                => '80',
    docroot             => $docroot,
    fallbackresource    => '/index.php',
    override            => 'all',
    custom_fragment     => 'AddType application/x-httpd-php .php'
    #    ProxyPassMatch ^/(.*\\.php(/.*)?)$ ${fastcgi_socket}",
  }
}