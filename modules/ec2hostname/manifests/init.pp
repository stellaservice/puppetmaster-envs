# == Class: ec2hostname
#
# This class installs and configures ec2hostname
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
class ec2hostname (
  $aws_key,
  $aws_secret,
  $zone,
  $install_gem  = $::ec2hostname::params::install_gem,
  $hostname     = $::ec2hostname::params::hostname,
  $domain       = $::ec2hostname::params::domain,
  $ttl          = $::ec2hostname::params::ttl,
  $type         = $::ec2hostname::params::type,
  $target       = $::ec2hostname::params::target,
  $service      = $::ec2hostname::params::service,
  $enable       = $::ec2hostname::params::enable,
  $systemd      = $::ec2hostname::params::systemd,
) inherits ec2hostname::params {

  if ( !is_integer($ttl) ) {
    fail('ec2hostname: TTL must be an integer')
  }

  validate_re($service, [ '^running$', '^stopped$'])
  validate_re($type, [ '^[aA]$', '^[cC][nN][aA][mM][eE]$'])

  anchor { 'ec2hostname::begin': } ->
  class { 'ec2hostname::install': } ->
  class { 'ec2hostname::config':
    aws_key    => $aws_key,
    aws_secret => $aws_secret,
    hostname   => $hostname,
    domain     => $domain,
    ttl        => $ttl,
    type       => $type,
    target     => $target,
    zone       => $zone,
  } ~>
  class { 'ec2hostname::service': } ->
  anchor { 'ec2hostname::end': }

}
