define bsl_infrastructure::provider::aws::vpc_subnet(
  $region,
  $vpc = undef,
  $cidr_block = undef,
  $availability_zone = undef,
  $tags = undef,
  $route_table = undef,
  $routes = undef,
) {
  $default_tags = {
    'Name'           => $name,
    'puppet_managed' => 'true',
  }

  if $tags {
    validate_hash($tags)
    $set_tags = merge($tags, $default_tags)
  }
  else {
    $set_tags = $default_tags
  }

  ec2_vpc { $title:
    name         => $name,
    region       => $region,
    cidr_block   => $cidr_block,
    dhcp_options => $dhcp_options,
    tags         => $set_tags,
  }

  if $vpc {
    Ec2_vpc[$vpc]->Ec2_securitygroup[$name]
  }
}
