define bsl_infrastructure::provider::aws::iam_role(
  $ensure = 'present',
  $service_principal = 'ec2.amazonaws.com',
  $instance_profile = 'true',
) {
  iam_role { $title:
    ensure          => $ensure,
    name            => $name,
    policy_document => template('bsl_infrastructure/iam/policies/assumed_role_trust.erb')
  }

  if str2bool($instance_profile) {
    if $ensure == 'present' {
      iam_instance_profile { $title:
        ensure  => $ensure,
        name    => $name,
        roles   => [ $title ],
      }
    }
    else {
      iam_instance_profile { $title:
        name    => $name,
        ensure  => $ensure,
      }
    }
  }
}
