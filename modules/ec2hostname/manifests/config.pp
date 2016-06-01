# == Class: ec2hostname::config
#
# This class configures ec2hostname
#
#
# === Parameters
#
# See the README.md for complete documentation
#
#
# === Authors
#
# * Justin Lambert <mailto:jlambert@letsevenup.com>
#
class ec2hostname::config (
  $aws_key,
  $aws_secret,
  $hostname,
  $domain,
  $ttl,
  $type,
  $target,
  $zone,
) {

  if $caller_module_name != $module_name {
    fail("Use of private class ${name} by ${caller_module_name}")
  }

  file { '/etc/sysconfig/ec2hostname':
    ensure  => 'file',
    mode    => '0440',
    owner   => 'root',
    group   => 'root',
    content => template('ec2hostname/ec2hostname.sysconfig'),
  }
}
