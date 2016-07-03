class bsl_core::debug(
  $message = 'hello from bsl_core::debug (debug message not overridden)'
) {
  notify { 'bsl_core_debug (common)':
    message => "#### bsl_core_debug: ${message}"
  }

  if $::ec2_tag_profile {
    notify { "ec2_tag_profile: ${::ec2_tag_profile}": }
  }
  else {
    notify { "no ec2_tag_profile available": }
  }

  if $::ec2_tag_role {
    notify { "ec2_tag_role: ${::ec2_tag_role}": }
  }
  else {
    notify { "no ec2_tag_role available": }
  }

  $hello_worlds = hiera_array('hello_worlds', [])
  if !empty($hello_worlds) {
    $joined = join($hello_worlds, "\n  - ")
    notify { '## bsl_core::debug hello_worlds':
      message => "  - ${joined}",
    }
  }
}
