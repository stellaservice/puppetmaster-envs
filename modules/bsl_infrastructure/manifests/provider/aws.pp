class bsl_infrastructure::provider::aws(
  $vpcs = undef,
  $security_groups = undef,
) {
  assert_private("bsl_infrastructure::provider::aws is private and cannot be invoked directly")

  include 'bsl_infrastructure::provider::aws::sdk'

  if $vpcs {
    validate_hash($vpcs)

    $vpc_defaults = {
      require => Class['bsl_infrastructure::provider::aws::sdk'],
    }

    create_resources('bsl_infrastructure::provider::aws::vpc', $vpcs, $vpc_defaults)
  }
  
  if $security_groups {
    validate_hash($security_groups)

    $sg_defaults = {
      require => Class['bsl_infrastructure::provider::aws::sdk'],
    }

    create_resources('bsl_infrastructure::provider::aws::security_group', $security_groups, $sg_defaults)
  }
}
