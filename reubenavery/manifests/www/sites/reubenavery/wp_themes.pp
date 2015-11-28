class reubenavery::www::sites::reubenavery::wp_themes(
  $home,
  $docroot,
  $www_user,
) {
  include sys::unzip

  $theme_dir = "$docroot/wp-content/themes"
  $theme_src_dir = "$home/wp-themes"
  $theme_src_dir_managed = "$home/wp-themes/puppet-managed"

  file { [$theme_dir, $theme_src_dir]:
    ensure   => directory,
    owner    => $www_user,
    group    => $www_user,
  }
  ->
  file { $theme_src_dir_managed:
    ensure   => directory,
    recurse  => true,
    source   => 'puppet:///modules/reubenavery/wp-themes',
    owner    => $www_user,
    group    => $www_user,
    mode     => '0755',
  }
  ->
  exec { 'extract-center-main':
    cwd     => $theme_dir,
    command => "unzip -u $theme_src_dir_managed/center-main/center.zip",
    path    => '/bin:/usr/bin',
    user    => $www_user,
  }
}
