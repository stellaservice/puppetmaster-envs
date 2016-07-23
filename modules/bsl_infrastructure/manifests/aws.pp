class bsl_infrastructure::aws {
  assert_private("${module_name} is private and cannot be invoked directly")
  require 'bsl_infrastructure'
  require 'bsl_infrastructure::aws::sdk'
}
