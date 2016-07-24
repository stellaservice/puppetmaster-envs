define bsl_infrastructure::resource::aws::service(
  $purge = 'false',
  $bsl_account_id,
  $vpc_tenant_id,
  $instances = undef,
) {
  if $instances {
    validate_hash($instances)

    $ec2_instance_defaults = {
      bsl_account_id => $bsl_account_id,
      vpc_tenant_id => $vpc_tenant_id,
    }

    create_resources('bsl_infrastructure::resource::aws::service::ec2_instance', $instances, $ec2_instance_defaults)
  }

}
