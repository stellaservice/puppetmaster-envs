# == Class: ec2hostname::install
#
# This class installs the ec2hostname init script and optionally the aws-sdk gem
#
#
# === Authors
#
# * Justin Lambert <mailto:jlambert@letsevenup.com>
#
class ec2hostname::install (
  $install_gem = $::ec2hostname::install_gem,
) {

  if $caller_module_name != $module_name {
    fail("Use of private class ${name} by ${caller_module_name}")
  }

  include ::ec2hostname::params

  if ( $install_gem ) {
    # Packages needed to build the gem
    package { $::ec2hostname::params::gem_package_deps:
      ensure => 'installed',
      before => Package['nokogiri'],
    }

    # Nokogiri is defined to ensure a ruby 1.8.7 version if needed
    package { 'nokogiri':
      ensure   => $::ec2hostname::params::nokogiri_gem_ver,
      provider => 'gem',
    }

    package { 'aws-sdk':
      ensure   => 'installed',
      provider => 'gem',
      require  => Package['nokogiri'],
    }
  }

  if $::ec2hostname::systemd {
    file { '/usr/lib/systemd/system/ec2hostname.service':
      ensure => 'file',
      source => 'puppet:///modules/ec2hostname/ec2hostname.service',
    }
  } else {
    file { '/etc/init.d/ec2hostname':
      ensure => 'file',
      source => 'puppet:///modules/ec2hostname/ec2hostname.init',
    }
  }

  file { '/usr/local/sbin/ec2hostname':
    owner  => 'root',
    group  => 'root',
    mode   => '0554',
    source => 'puppet:///modules/ec2hostname/ec2hostname',
  }

}
