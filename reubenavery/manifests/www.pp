class reubenavery::www(
  $fastcgi_socket = 'fcgi://127.0.0.1:9000/$1',
) {
  include reubenavery
  class { 'drupal_php':
    apache_mods => [
      'actions',
      'alias',
      'auth_basic',
      'authn_file',
      'authz_groupfile',
      'authz_user',
      'autoindex',
      'deflate',
      'dir',
      'env',
      'expires',
      'fastcgi',
      'headers',
      'mime',
      'mime_magic',
      'negotiation',
      'reqtimeout',
      'rewrite',
      'setenvif',
      'status',
      'suexec',
      'xsendfile',
    ],
  }

  #  include apache::mod::alias
  #  include apache::mod::actions
  #  include apache::mod::fastcgi
  #
  #  include php
  #  include php::fpm

  apache::fastcgi::server { 'php':
    host       => '127.0.0.1:9000',
    timeout    => 15,
    flush      => false,
    faux_path  => '/var/www/php.fcgi',
    fcgi_alias => '/php.fcgi',
    file_type  => 'application/x-httpd-php'
  }


}