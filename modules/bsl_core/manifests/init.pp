class bsl_core(
  $service_acct = $bsl_core::params::service_acct,
  $manage_hostname = 'false'
) inherits bsl_core::params {
  if $::ec2_metadata and $::ec2_metadata['instance-id'] {
    $ec2_instance_id = $::ec2_metadata['instance-id']
  }

  $puppetmaster_fqdn = hiera('puppetmaster', 'puppet')

  if $::ec2_metadata and $::ec2_metadata['iam'] and $::ec2_metadata['iam']['info'] {
    $iam_info = parsejson($::ec2_metadata['iam']['info'])
    $iam_arn = $iam_info['InstanceProfileArn']
    $iam_profile_id = $iam_info['InstanceProfileId']
    $iam_profile_name = regsubst($iam_arn, '^.*\/', '')
  }

  file { ['/etc/facter', '/etc/facter/facts.d']:
    ensure => directory,
  }

  file { '/etc/facter/facts.d/bitswarm-ec2.yaml':
    ensure  => file,
    content => template('bsl_core/bitswarm-ec2.yaml.erb'),
    require => File['/etc/facter/facts.d'],
  }

  if $::ec2_tag_hostname and str2bool($manage_hostname) {
    class { 'hostname':
      hostname => $::ec2_tag_hostname,
      domain   => hiera('domain', $::domain),
    }
  }
}
