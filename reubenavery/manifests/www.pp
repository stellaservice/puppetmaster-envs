class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery::wordpress

  class { '::apache':
    default_vhost => false,
  }

  include apache::mod::php

  class { '::php':

  }

  apache::vhost { 'reubenavery-www':
    port                => '80',
    docroot             => $reubenavery::wordpress::home,
    fallbackresource    => '/index.php',
    override            => 'all',
    custom_fragment     => "ProxyPassMatch ^/(.*\\.php(/.*)?)$ ${fastcgi_socket}",
  }

  Class['apache']->anchor { '::reubenavery:www': }
}