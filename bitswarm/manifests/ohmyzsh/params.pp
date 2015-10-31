# Parameters class for bitswarm::ohmyzsh
class bitswarm::ohmyzsh::params {

  case $::osfamily {
    'Redhat': {
      $zsh = '/bin/zsh'
    }
    default: {
      $zsh = '/usr/bin/zsh'
    }
  }

  $home = '/home'

}
