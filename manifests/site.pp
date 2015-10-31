node default {
  class { '::site::roles::base': }
  class { '::site::roles::packages': }
  class { '::bitswarm::users': }
}

node 'ip-10-108-0-134.bitswarm.internal' {
  host { 'ip-10-108-0-134.bitswarm.internal':
    ip => $ipaddress,
    host_aliases => ['ip-10-108-0-134', 'reubenavery-www', 'reubenavery-www.bitswarm.internal']
  }

  file { "/etc/hostname":
    ensure => present,
    owner => root,
    group => root,
    mode => 644,
    content => "reubenavery-www",
    notify => Exec["set-hostname"],
  }

  exec { "set-hostname":
    command => "/bin/hostname -F /etc/hostname",
    unless => "/usr/bin/test `hostname` = `/bin/cat /etc/hostname`",
#    notify => Service[$rsyslog::params::service_name],
  }
}