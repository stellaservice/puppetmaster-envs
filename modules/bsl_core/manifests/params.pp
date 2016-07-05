class bsl_core::params {
  case $::osfamily {
    'Debian': {
      $service_acct = 'admin'
    }
    'Ubuntu': {
      $service_acct = 'ubuntu'
    }
  }

  $credstash_config_file = '/etc/puppet-credstash.yaml'
  $credstash_region = 'us-west-1'
  $credstash_dynamodb_table = 'credentials'
  $credstash_encryption_contexts = {
    environment => 'prod',
    app_tier    => 'web',
    product     => 'MyApp',
  }
}
