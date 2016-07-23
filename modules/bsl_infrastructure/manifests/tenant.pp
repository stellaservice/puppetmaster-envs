define bsl_infrastructure::tenant(
  $bsl_account_id = $name,
  $vpc_tenant_id = $name,
  $internal_domain = hiera('domain', $::domain),
  $puppetmaster = hiera('puppetmaster', 'puppet'),
  $providers = undef,
) {
  assert_private("${module_name} is private and cannot be invoked directly")

  bsl_account::verify { $name:
    account_id => $bsl_account_id,
    tenant_id  => $vpc_tenant_id,
  }

  $defaults = {
    bsl_account_id  => $bsl_account_id,
    vpc_tenant_id   => $vpc_tenant_id,
    internal_domain => $internal_domain,
    puppetmaster    => $puppetmaster,
  }

  if $providers {
    validate_hash($providers)
    create_resources('bsl_infrastructure::provider', $providers, $defaults)
  }
}
