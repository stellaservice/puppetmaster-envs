define bsl_infrastructure::provider::aws::vpc(
  $region = undef,
  $cidr_block = undef,
  $dhcp_options = undef,
  $instance_tenancy = undef,
  $tags = undef,
) {
  $default_tags = {
    'Name' => $name,
  }

  if $tags {
    validate_hash($tags)
    $set_tags = merge($default_tags, $tags)
  }
  else {
    $set_tags = $default_tags
  }

  ec2_securitygroup { $name:
    region => $region,
    description => $description,
    ingress => $ingress,
    tags => $set_tags,
    vpc => $vpc,
  }

  if $vpc {
    Ec2_vpc[$vpc]->Ec2_securitygroup[$name]
  }
}
