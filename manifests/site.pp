# node default {
#   class { '::site::roles::base': }
#   class { '::site::roles::packages': }
#   class { '::bitswarm::users': }
# }
#
# import 'nodes/*.pp'