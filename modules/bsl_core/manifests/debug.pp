class bsl_core::debug(
  $message = 'hello world'
) {
  notify { 'bsl_core_debug':
    message => "#### bsl_core_debug: ${message}"
  }
}
