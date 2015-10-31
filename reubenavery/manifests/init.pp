class reubenavery(
  $srv_home = $reubenavery::params::home,
  $www_user = $reubenavery::params::www_user,
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
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
}