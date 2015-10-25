node default {
  class { '::site::roles::base': }
  class { '::bitswarm::users': }
}