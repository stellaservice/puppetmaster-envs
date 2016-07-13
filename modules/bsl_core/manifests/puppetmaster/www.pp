class bsl_core::puppetmaster::www(
  $puppetboard_http_port,
  $rancher_http_port,
  $r10k_webhook_port,
  $force_ssl,
) {
  include nginx

  $server_name = $rancher::server_host
  $ssl_key = "${::nginx::config::conf_dir}/ssl/STAR_jjc-devops_com.key"
  $ssl_cert = "${::nginx::config::conf_dir}/ssl/STAR_jjc-devops_com-bundle.crt"

  user { $::nginx::config::daemon_user:
    ensure => present,
    system => true,
  }
  ->
  file { "${::nginx::config::conf_dir}/ssl":
    ensure  => directory,
    mode    => '0700',
    notify  => Service['nginx'],
  }
  # ->
  # file { $ssl_key:
  #   source  => 'puppet:///modules/rancher/ssl/STAR_jjc-devops_com.key',
  #   mode    => '0400',
  #   notify  => Service['nginx'],
  # }
  # ->
  # concat { $ssl_cert:
  #   mode    => '0400',
  #   before  => Service['nginx'],
  # }
  #
  # concat::fragment { 'STAR_jjc-devops_com.crt':
  #   target  => $ssl_cert,
  #   source  => 'puppet:///modules/rancher/ssl/STAR_jjc-devops_com.crt',
  #   order   => '00',
  #   notify  => Service['nginx'],
  # }
  #
  # concat::fragment { 'STAR_jjc-devops_com.ca-bundle':
  #   target  => $ssl_cert,
  #   source  => 'puppet:///modules/rancher/ssl/STAR_jjc-devops_com.ca-bundle',
  #   order   => '99',
  #   notify  => Service['nginx'],
  # }

  file { "${::nginx::config::conf_dir}/sites-available/00-puppetboard.conf":
    content => template('bsl_core/puppetmaster/puppetboard-conf.erb'),
    notify  => Service['nginx'],
  }
  ->
  file { "${::nginx::config::conf_dir}/sites-enabled/00-puppetboard.conf":
    ensure => link,
    target => "${::nginx::config::conf_dir}/sites-available/00-puppetboard.conf",
    notify => Service['nginx'],
  }

  file { "${::nginx::config::conf_dir}/sites-available/00-rancher.conf":
    content => template('bsl_core/puppetmaster/rancher-conf.erb'),
    notify  => Service['nginx'],
  }
  ->
  file { "${::nginx::config::conf_dir}/sites-enabled/00-rancher.conf":
    ensure => link,
    target => "${::nginx::config::conf_dir}/sites-available/00-rancher.conf",
    notify => Service['nginx'],
  }
}
