define bsl_infrastructure::provider(
  $purge = 'false',
  $tenant_id,
  $internal_domain = undef,
  $puppetmaster = undef,
  $config = undef,
) {
  include 'bsl_infrastructure::auth'

  if defined("bsl_infrastructure::provider::${name}") {
    class { "bsl_infrastructure::${name}":
      internal_domain   => $internal_domain,
      puppetmaster      => $puppetmaster,
    }

    if $config {
      validate_hash($config)

      class { "bsl_infrastructure::provider::${name}":
        purge             => $purge,
        tenant_id         => $tenant_id,
        services          => $config['services'],
        zones             => $config['zones'],
        vpcs              => $config['vpcs'],
        require           => Class["bsl_infrastructure::${name}"],
      }
    }
  }
  else {
    fail("unknown provider: ${name}")
  }
}
