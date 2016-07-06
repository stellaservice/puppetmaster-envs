class bsl_core::puppetmaster(
  $manage_infrastructure = 'false',
) {
  include bsl_core::rancher::server

  notify { '## hello from CORE (environments/core) bsl_core::puppetmaster': }

  if $::osfamily == 'Debian' {
    include apt
  }

  # Relying on configuration via Hiera
  include '::bsl_puppet'

  if str2bool($manage_infrastructure) {
    notify { "## managing infrastructure": }

    if defined('bsl_infrastructure') {
      include 'bsl_infrastructure'
    }
    else {
      notify { 'bsl_infrastructure not available for bsl_core::puppetmaster': }
      err('bsl_infrastructure not available for bsl_core::puppetmaster')
    }
  }


  # class { '::aws_scheduler':
  #   aws_access_key_id     => $::bsl_puppet::config::server_aws_api_key,
  #   aws_secret_access_key => $::bsl_puppet::config::server_aws_api_secret,
  #   aws_region            => $::bsl_puppet::config::server_aws_default_region,
  #   tag                   => 'schedule',
  #   exclude               => '[]',
  #   default               => '{"mon": {"start": 9, "stop": 18},"tue": {"start": 9, "stop": 18},"wed": {"start": 9, "stop": 18},"thu": {"start": 9, "stop": 18}, "fri": {"start": 9, "stop": 18}}',
  #   time                  => 'local',
  #   log                   => '/var/log/aws-scheduler_cron.log',
  #   require               => Class['::bsl_puppet']
  # }
}
