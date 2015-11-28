class reubenavery::www::sites::reubenavery::wp_themes(
  $home,
  $docroot,
  $www_user,
) {
  include sys::unzip

  $theme_dir = "$docroot/wp-content/themes"
  $theme_src_dir = "$home/wp-themes"

  file { $theme_dir:
    ensure   => directory,
    owner    => $www_user,
    group    => $www_user,
  }

  file { $theme_src_dir:
    ensure   => directory,
    recurse  => remote,
    source   => 'puppet:///modules/reubenavery/wp-themes',
    owner    => $www_user,
    group    => $www_user,
    mode     => '0755',
  }

  file { "$theme_src_dir/center-main":
    ensure  => directory,
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
