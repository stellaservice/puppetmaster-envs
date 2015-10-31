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
  file { $srv_home:
    ensure => directory,
    owner  => $www_user,
    group  => $www_user,
  }
}