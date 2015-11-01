node default {
  class { '::site::roles::base': }
  class { '::site::roles::packages': }
  class { '::bitswarm::users': }
}

include 'nodes/**.pp'