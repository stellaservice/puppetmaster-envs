define bsl_infrastructure::provider::aws::iam_policy(
  $ensure = 'present',
  $document_contents = undef,
  $document_template = undef,
  $users = undef,
  $groups = undef,
  $roles = undef,

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
    document => $document,
  }

  if $users or $groups or $roles {
    if $users {
      validate_array($users)
    }
    if $groups {
      validate_array($groups)
    }
    if $roles {
      validate_array($roles)
    }

    iam_policy_attachment { $title:
      users  => $users,
      groups => $groups,
      roles  => $roles,
    }
  }
}
