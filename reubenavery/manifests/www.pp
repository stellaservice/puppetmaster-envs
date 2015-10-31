class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery::wordpress
  include apt
  # deb http://us-east-1.ec2.archive.ubuntu.com/ubuntu/ trusty-backports main restricted universe multiverse
  # deb-src http://us-east-1.ec2.archive.ubuntu.com/ubuntu/ trusty-backports main restricted universe multiverse
  apt::source { 'backports':
    location    => 'http://us-east-1.ec2.archive.ubuntu.com/ubuntu/',
    key         => '630239CC130E1A7FD81A27B140976EAF437D05B5',
    repos       => 'main restricted universe multiverse',
    include_src => true,
    require     => Class['apt'],
  }
  ->
  class { '::apache':
    default_vhost => false,
  }
  class { '::apache::mod::fastcgi':

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