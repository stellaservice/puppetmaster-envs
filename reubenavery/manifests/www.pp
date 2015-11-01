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

  class { '::apache':
    default_vhost => false,
  }

  include apache::mod::alias
  include apache::mod::actions
  
  class { 'php::fpm': }
  ->
  apache::fastcgi::server { 'php':
    host       => '127.0.0.1:9000',
    timeout    => 15,
    flush      => false,
    faux_path  => '/var/www/',
    fcgi_alias => '/usr/lib/cgi-bin/',
    file_type  => 'php.fcgi'# 'application/x-httpd-php'
  }
#FastCGIExternalServer /var/www/php.fcgi -idle-timeout 15  -host 127.0.0.1:9000
#Alias /php.fcgi /var/www/php.fcgi
#Action application/x-httpd-php /php.fcgi

#FastCgiExternalServer /var/www/php5.external -host 127.0.0.1:9000
#AddHandler php5-fcgi .php
#Alias /usr/lib/cgi-bin/	/var/www/
#Action php5-fcgi /usr/lib/cgi-bin/php5.external

apache::vhost { 'reubenavery-www':
    port                => '80',
    docroot             => $reubenavery::wordpress::home,
    fallbackresource    => '/index.php',
    override            => 'all',
#    custom_fragment     => "AddType application/x-httpd-php .php
#    ProxyPassMatch ^/(.*\\.php(/.*)?)$ ${fastcgi_socket}",
  }

  Class['apache']->anchor { '::reubenavery:www': }
}