node default {
  class { '::site::roles::base': }
  class { '::site::roles::packages': }
  class { '::bitswarm::users': }
}

node 'ip-10-108-0-134.bitswarm.local' {
  host { 'ip-10-108-0-134.bitswarm.local':
    ip => $ipaddress,
  }
}