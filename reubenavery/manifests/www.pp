class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery
  include ::php::pear
  include ::drupal_php

#
#  class { '::apache':
#    default_vhost => false,
#  }
#
#  include apache::mod::alias
#  include apache::mod::actions
#  include php
#  include php::fpm
#  include php::extension::mysql
#
#  apache::fastcgi::server { 'php':
#    host       => '127.0.0.1:9000',
#    timeout    => 15,
#    flush      => false,
#    faux_path  => '/var/www/php.fcgi',
#    fcgi_alias => '/php.fcgi',
#    file_type  => 'application/x-httpd-php'
#  }


}