define bsl_infrastructure::provider::aws::iam_policy(
  $ensure = 'present',
  $document_contents = undef,
  $document_template = undef,
) {
  if $document_contents {
    $document = $document_contents
  }
  elsif $document_template {
    $document = template($document_template)
  }
  else {
    fail 'not sure what you want me to do here, need either $document_contents or $document_template path'
  }

  iam_policy { $title:
    ensure   => $ensure,
    name     => $name,
    document => $document_template,
  }

  if $vpc {
    Ec2_vpc[$vpc]->Ec2_securitygroup[$name]
  }

  if $subnets {
    validate_hash($subnets)

    $vpc_subnet_defaults = {
      vpc     => $name,
      region  => $region,
      require => Ec2_vpc[$title],
    }

    create_resources('bsl_infrastructure::provider::aws::vpc_subnet', $subnets, $vpc_subnet_defaults)
  }
}
