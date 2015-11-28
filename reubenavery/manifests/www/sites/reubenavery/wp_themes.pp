class reubenavery::www::sites::reubenavery::wp_themes {
  include reubenavery::www::sites::reubenavery
  include sys::unzip

  $docroot = $reubenavery::www::sites::reubenavery::docroot
  $www_user = $reubenavery::www::sites::reubenavery::www_user
  $theme_dir = "$docroot/wp-content/themes"
  $theme_src_dir = "$docroot/wp-themes"

  file { $theme_dir:
    ensure   => directory,
    owner    => $www_user,
    group    => $www_user,
  }

  file { $theme_src_dir:
    ensure   => directory,
    source  => 'puppet:///modules/reubenavery/wp-themes',
    owner   => $www_user,
    group   => $www_user,
  }

  file { "$theme_src_dir/center-main":
    ensure => directory,
    require => File[$theme_src_dir],
  }
  ->
  exec { 'extract-center-main':
    cwd     => $theme_dir,
    command => "unzip $theme_src_dir/center-main/center.zip",
    path    => '/bin:/usr/bin',
    require => File[$theme_dir],
  }
}
