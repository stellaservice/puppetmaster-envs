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

  if $tags {
    validate_hash($tags)
  }

  ec2_securitygroup { $name:
    region => $region,
    description => $description,
    ingress => $ingress,
    tags => $tags,
    vpc => $vpc,
  }

  if $vpc {
    Ec2_vpc[$vpc]->Ec2_securitygroup[$name]
  }
}
