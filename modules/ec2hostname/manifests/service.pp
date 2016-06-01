# == Class: ec2hostname::service
#
# This class manages the ec2hostname service
#
#
# === Authors
#
# * Justin Lambert <mailto:jlambert@letsevenup.com>
#
class ec2hostname::service {

  if $caller_module_name != $module_name {
    fail("Use of private class ${name} by ${caller_module_name}")
  }

  service { 'ec2hostname':
    ensure => $::ec2hostname::service,
    enable => $::ec2hostname::enable,
  }

}
