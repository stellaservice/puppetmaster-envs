# == Class: ec2hostname::params
#
# This class sets the defaults for the ec2hostname module
#
#
# === Authors
#
# * Justin Lambert <mailto:jlambert@letsevenup.com>
#
class ec2hostname::params {

  $install_gem = false
  $hostname    = $::hostname
  $domain      = $::domain
  $ttl         = 60
  $type        = 'CNAME'
  $target      = 'local-hostname'
  $service     = 'running'
  $enable      = true

  case $::osfamily {
    'RedHat': {
      case $::operatingsystemmajrelease {
        '6': {
          $gem_package_deps = [ 'ruby-devel', 'libxml2-devel', 'libxslt-devel' ]
          $nokogiri_gem_ver = '1.5.11'
          $systemd = false
        }
        '7': {
          $gem_package_deps = [ 'ruby-devel' ]
          $nokogiri_gem_ver = 'installed'
          $systemd = true
        }
        default: {
          fail('Versions 6 and 7 of RHEL-based systems are supported')
        }
      }
    }
    'Debian': {
      $systemd = false
      case $::lsbmajdistrelease {
        '12.04': {
          $gem_package_deps = [ 'rubygems', 'libxslt-dev', 'libxml2-dev' ]
          $nokogiri_gem_ver = '1.5.11'
        }
        '14.04': {
          $gem_package_deps = [ 'ruby-dev', 'libxml2-dev', 'libxslt-dev' ]
          $nokogiri_gem_ver = '1.6.1'
        }
        default: {
          fail('Versions 12.04 and 14.04 of Ubuntu systems are supported')
        }
      }
    }
    default: {
      fail("${::osfamily} is not supported by ec2hostname")
    }
  }
}
