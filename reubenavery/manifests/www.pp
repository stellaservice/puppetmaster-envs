class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery::wordpress

  class { '::apache':
    default_vhost => false,
  }

  class { 'apache::mod::php':
#    content => '
#AddHandler php5-script .php
#AddType text/html .php',
  }

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