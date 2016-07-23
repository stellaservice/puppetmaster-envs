define bsl_infrastructure::provider(
  $purge = 'false',
  $default = 'false',
  $account_id,
  $tenant_id = undef,
  $internal_domain = hiera('domain', $::domain),
  $puppetmaster = hiera('puppetmaster', 'puppet'),
  $config = [],
) {
  assert_private("${module_name} is private and cannot be invoked directly")
  # notify { "## hello from bsl_infrastructure::provider for account=$account_id tenant=$tenant_id provider=${name}": }

  if str2bool($purge) {
    $_ensure = 'absent'
  }
  else {
    $_ensure = 'present'
  }

  validate_string($account_id)
  validate_hash($config)

  if defined("bsl_infrastructure::provider::${name}") {
    class { "bsl_infrastructure::${name}": }->
    class { "bsl_infrastructure::provider::${name}":
      ensure            => $_ensure,
      default           => $default,
      account_id        => $account_id,
      tenant_id         => $tenant_id,
      internal_domain   => $internal_domain,
      puppetmaster      => $puppetmaster,
      services          => $config['services'],
      zones             => $config['zones'],
      vpcs              => $config['vpcs'],
      require           => Bsl_account::Verify[$account_id],
    }
    contain("bsl_infrastructure::provider::${name}")
  }
  else {
    fail("unknown provider: ${name}")
  }
}
