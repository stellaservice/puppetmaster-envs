define bsl_infrastructure::provider::aws::security_group(
  $ensure = 'present',
  $region,
  $description,
  $ingress = undef,
  $tags = undef,
  $vpc = undef,
) {
  if $ingress {
    validate_array($ingress)
  }

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
