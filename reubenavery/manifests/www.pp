class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery
  include drupal_php

  include php
  include php::fpm
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