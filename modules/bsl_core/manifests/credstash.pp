class bsl_core::credstash(
  $config_file                 = $bsl_core::params::credstash_config_file,
  $aws_region                  = $bsl_core::params::credstash_region,
  $aws_dynamodb_table          = $bsl_core::params::credstash_dynamodb_table,
  $aws_kms_encryption_contexts = $bsl_core::params::credstash_encryption_contexts,
) inherits bsl_core::params {
  class { '::credstash': }

  validate_hash($aws_kms_encryption_contexts)

  file { $config_file:
    ensure => file,
    content => template('bsl_core/puppet-credstash.yaml.erb')
  }
}
