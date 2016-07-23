define bsl_infrastructure::aws::resource::route53::zone(
  $ensure = 'present',
  $account_id = hiera('bsl_account_id', $::bsl_account_id),
  $tenant_id = hiera('bsl_tenant_id', $::bsl_tenant_id),
  $comment = '',
  $type = 'private',
  $vpcs = {},
) {
  include 'bsl_infrastructure::aws'

  $debug_msg = "bsl_infrastructure::aws::resource::route53::zone[$title] not fully implemented, please see TODOs in \
    code"

  notify { "bsl_infrastructure::aws::resource::route53::zone[$title]":
    message => "## WARNING: ${$debug_msg}",
  }
  warning($debug_msg)

  include 'bsl_infrastructure::aws::resource::route53'

  $name_normalized = regsubst($name, '(([\w]+\.)*[\w]+)', '\0.')
  validate_re($name_normalized, '^((([\w]+\.)*[\w]+)\.)$')

  # TODO : the below only creates a public zone currently, also cannot associate with VPC, as $name is the only
  # implemented parameter.
  #
  route53_zone { $name:
    name => $name_normalized,
  }
  #
  # needs to support:
  # route53_zone { $name:
  #   type => $type,
  #   comment => $comment,
  #   vpcs => $vpcs,
  #   ensure => $ensure,
  # }
}
