class reubenavery(
  $srv_home = $reubenavery::params::home,
  $www_user = $reubenavery::params::www_user,
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
  $db_root_pw = 'dakos934jkx',
) inherits reubenavery::params {
  file { '/srv':
    ensure => directory,
  }
  ->
  user { $www_user:
    ensure     => present,
    home       => $srv_home,
    managehome => true,
  }

  group { $www_user:
    ensure => present,
  }

  class { '::mysql::server':
    root_password           => $db_root_pw,
    remove_default_accounts => true,
  }

}