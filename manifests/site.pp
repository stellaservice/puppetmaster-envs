# node default {
#   class { '::site::roles::base': }
#   class { '::site::roles::packages': }
#   class { '::bitswarm::users': }
# }
#

hiera_include('classes')

import 'nodes/*.pp'
