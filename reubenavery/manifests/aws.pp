class reubenavery::aws(
  $data_device_path = '/dev/xvdf',
  $data_mount_path = '/srv',
  $fstype = 'ext4',
  $fstab_options = 'auto,nofail,defaults',
) inherits reubenavery::params {
  file { $data_mount_path:
    ensure => directory,
    before => Mount[$data_mount_path],
  }
  ->
  mount { $data_mount_path:
    device  => $data_device_path,
    ensure  => mounted,
    fstype  =>  $fstype,
    options => $fstab_options,
  }
}