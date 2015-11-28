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
    recurse  => true,
    source   => 'puppet:///modules/reubenavery/wp-themes',
    owner    => $www_user,
    group    => $www_user,
    mode     => '0755',
  }

  exec { 'extract-center-main':
    cwd     => $theme_dir,
    command => "unzip $theme_src_dir/center-main/center.zip",
    path    => '/bin:/usr/bin',
    user    => $www_user,
    require => File[$theme_dir],
  }
}
