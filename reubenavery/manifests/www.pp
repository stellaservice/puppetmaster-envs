class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery::wordpress

  class { '::apache':
    default_vhost => false,
  }

  class { '::php':
    fpm => true,
  }

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