class bsl_core::puppetmaster(
  $manage_infrastructure = 'false',
) {
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

  class { 'aws_scheduler':
    tag                   => 'schedule',
    exclude               => '[]',
    default               => '{"mon": {"start": 5, "stop": 18},"tue": {"start": 5, "stop": 18},"wed": {"start": 5, "stop": 18},"thu": {"start": 5, "stop": 18}, "fri": {"start": 5, "stop": 18}}',
    time                  => 'gmt',
    script_path           => '/usr/sbin',
    cron_minute           => '10',
    cron_hour             => '*',
    log                   => '/var/log/aws-scheduler_cron.log',
  }
}
