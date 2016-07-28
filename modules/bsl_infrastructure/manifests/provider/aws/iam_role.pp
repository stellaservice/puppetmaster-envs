define bsl_infrastructure::provider::aws::iam_role(
  $ensure = 'present',

) {
  iam_role { $title:
    ensure   => $ensure,
    name     => $name,
  }
}
