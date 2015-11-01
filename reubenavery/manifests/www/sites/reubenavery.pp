class reubenavery::www::sites::reubenavery(
  $home = '/srv/reubenavery-www',
  $docroot = "/srv/reubenavery-www/wordpress",
  $www_user = 'reubenavery-www',
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
) inherits reubenavery::params {
  include reubenavery::www

  user { $www_user:
    ensure     => present,
    home       => $home,
    managehome => true,
  }
  ->
  group { $www_user:
    ensure => present,
  }
  ->
  file { $docroot:
    ensure => directory,
    owner  => $www_user,
    group  => $www_user,
  }
  ->
  class { '::wordpress':
    install_dir => $docroot,
    wp_owner    => $www_user,
    wp_group    => $www_user,
    db_user     => $db_user,
    db_password => $db_pass,
  }

  apache::vhost { 'reubenavery-www':
    servername          => 'www.reubenavery.com',
    serveraliases       => ['reubenavery.com'],
    port                => '80',
    docroot             => $docroot,
#    fallbackresource    => '/index.php',
    override            => 'all',
#    custom_fragment     => 'AddType application/x-httpd-php .php'
    #    ProxyPassMatch ^/(.*\\.php(/.*)?)$ ${fastcgi_socket}",
  }

  ssh_authorized_key { 'reubenavery-www-general':
    user => $www_user,
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAACAQC4nBaJAjFyPk8/s+Mwgm9wwFilbbyQNEANCgwkYlfAzSKsW9Gw6ZAJyjuxsJCpcvkWnvTy7DOX0/gOuxChW3FB4a1VOeYaoIUslbsUpfCCXcSeg8lSwwWS1RJcXAgGKHStik/7jlmJ88CS21b1YtsgAy5+jkxqAOwwHvrYOATUJjTfdgxrMLediIHm5oEUCo8AgnrkyFNQraUgdhXQkVYXHsmlYQu58q22ae+sG4yZzqw08y0UUHDzPyCecxbbNygSysvn89xyddpbQN+FSTD5Du39aCEKEsL1PGRJKvtkSCK1jY73kTeLQYL0QiJoZLecblC8W0veKUFk57Va4B0V194+yfLiseqOZSgzmt38VkK3qyJlc9VB4zhJWQVh1j9vYb3sF47luT5Um/GXX1lNB90VvlbTVUXlX15Qq8JuOTTn+5zZD5rXXHRYIyRH60Yu1slij25Ox2lf1zeTbhgGGicLfRtmivIbcngLZ/R3sLT+dOsCILY1BAmV92TMwkiTPulFGsKsEzKhQWpYMig0aTw7u3Hv3nCVfk+uQFCpiEDHVfxYivPLMwOG7rDX2squB8M8dOq4Xj+et0KrdJEVHnRwxiSHM2ogX14spFXzUmKPIOwl9wxXAcd7GJxYqpt3IhzIRC97rpe3m80h1HMJwoAzrf4aN5P20ecjO1c/uw==',
  }
}