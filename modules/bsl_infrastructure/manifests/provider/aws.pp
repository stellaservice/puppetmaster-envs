class bsl_infrastructure::provider::aws(
  $purge = 'false',
  $tenant_id,
  $services = undef,
  $zones = undef,
  $vpcs = undef,
) inherits bsl_infrastructure::provider::aws::params {
  assert_private("bsl_infrastructure::provider::aws is private and cannot be invoked directly")

  require 'bsl_infrastructure::aws'

  if $vpcs {
    validate_hash($vpcs)

    $vpc_defaults = {
      ensure          => $ensure,
      account_id      => $bsl_account_id,
      tenant_id       => $vpc_tenant_id,
      internal_domain => $internal_domain,
      services        => $services,
      zones           => $zones,
    }

    create_resources('bsl_infrastructure::aws::resource::vpc', $vpcs, $vpc_defaults)
  }

  if $zones {
    validate_hash($zones)

    $zone_defaults = {
      ensure => 'present',
    }

    create_resources('bsl_infrastructure::aws::resource::route53::zone', $zones, $zone_defaults)
  }

  if $services {
    validate_hash($services)

    $service_defaults = {
      purge      => $purge,
      account_id => $account_id,
      tenant_id  => $tenant_id,
    }

    create_resources('bsl_infrastructure::aws::resource::ec2::service', $services, $service_defaults)
  }
}
