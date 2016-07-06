class bsl_core::rancher::server(
  $port = $bsl_core::params::rancher_port
) {
  assert_private('bsl_core classes are private')

  include docker

  class { '::rancher::server':
    port => $port,
  }
}
