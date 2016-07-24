define bsl_infrastructure::provider(
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
        security_groups => $config['security_groups'],
        require         => Class["bsl_infrastructure::${name}"],
      }
    }
  }
  else {
    fail("unknown provider: ${name}")
  }
}
