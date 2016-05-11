# node 'ip-10-108-0-245.bitswarm.internal' inherits default {
#   host { $fqdn:
#     ip           => $ipaddress,
#     host_aliases => ['ip-10-108-0-245', 'ip-10-108-0-245.bitswarm.internal', 'reubenavery-www', 'reubenavery-www.bitswarm.internal']
#   }
#
#   file { "/etc/hostname":
#     ensure  => present,
#     owner   => root,
#     group   => root,
#     mode    => 644,
#     content => "reubenavery-www",
#   }
#   ~>
#   exec { "set-hostname":
#     command     => "/bin/hostname -F /etc/hostname",
#     unless      => "/usr/bin/test `hostname` = `/bin/cat /etc/hostname`",
#     refreshonly => true,
#   }
#   ~>
#   exec { "reset-puppet-certs":
#     command     => "/usr/bin/find /var/lib/puppet/ssl -name '*.bitswarm.internal.pem' -delete",
#     refreshonly => true,
#   }
# }
#
# node 'reubenavery-www' inherits 'ip-10-108-0-245.bitswarm.internal' {
#
# }