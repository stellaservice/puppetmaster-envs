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

  ssh_authorized_key { $www_user:
    user => $www_user,
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAABAQDxBGMmBih454ng98CUjgTfW/j2f38WIgYgCYJUeEjs9Ovwmbz8ZVSYZ449txUB5z6hjaEG+/Fb1jrqXVqLWnLDgcDtCmayQD+3vUq2vTHPnaDILodssx7t8CWOOxEWVjXEI2OhHZSREQxci1u4u5PbiIgoA1vTLLCJwqLrfESaDqR2eF7ATHd83eKZrx4hCIZlEwjaIemQiQVYEvJ2XYCeBEg5U967k+5NS3kqnhObtqlEL4xzmtxBvqeOrL5Iwe9+qNXJG4rems54PXAnzp4ANdkFtXeJHbAcivD4NXgBk1NtPUCSB/kPKSlN9cgOOYf/cJDW4b0Cp3KZXOuZcJ6P',
  }

}