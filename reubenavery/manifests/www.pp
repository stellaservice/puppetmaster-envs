class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include apt
  class { 'apt::backports':
    repos    => 'main universe multiverse restricted',
    require  => Class['apt'],
  }
  include reubenavery::wordpress

  class { '::apache':
    default_vhost => false,
    require => Class['apt::backports'],
  }

  class { '::php':
    fpm => true,
  }

  include  apache::mod::fastcgi

  apache::fastcgi::server { 'php':
    host       => '127.0.0.1:9000',
    timeout    => 15,
    flush      => false,
    faux_path  => '/var/www/php.fcgi',
    fcgi_alias => '/php.fcgi',
    file_type  => 'application/x-httpd-php'
  }

  apache::vhost { 'reubenavery-www':
    port                => '80',
    docroot             => $reubenavery::wordpress::home,
    fallbackresource    => '/index.php',
    override            => 'all',
    custom_fragment     => "AddType application/x-httpd-php .php
    ProxyPassMatch ^/(.*\\.php(/.*)?)$ ${fastcgi_socket}",
  }

  Class['apache']->anchor { '::reubenavery:www': }
}