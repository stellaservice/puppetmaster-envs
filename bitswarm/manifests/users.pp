class bitswarm::users {
#  user { 'ubuntu':
#    ensure => absent,
#  }

  user { 'ravery':
    ensure => present,
    managehome => true,
  }
  ->
  ssh_authorized_key { 'ravery@bitswarm.io':
    user => 'ravery',
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAABAQDVIu0Y4jx2hQzeZOlxY1CDYE8exmCxgOE/ZaPLzc6gR7xkYb93PYOGEdRHZS4Vk/oilGOzruN/rNq+Ni4YMuhkrkZKoQalhHX88NUvG8xcePvIMiBdHavdkBzbHOn6qvZlsTFudZFM8BigoJ/iY9TtIyA0YKxCD8tfmbA7gZsd/+R60cxYXd1zx/gMtgmwBqRX1E8z7xfJn01bmJAErkiNkDyq2stbT/Uh8YhI0UmZ/q74Cr/x7R95cBeRjtmlRMMMAtqqqvxbQh3yox4M9XMZpA9Dt2cRdPNbJuhnv+bq444qfTw3vpaVDSqxdcuRGHPjbIH2W2sA6beifJ3Ozx1D',
  }
  sudo::sudoers { 'sysops':
    ensure   => 'present',
    users    => ['ravery'],
    runas    => ['root'],
    cmnds    => ['ALL'],
    tags     => ['NOPASSWD'],
    defaults => [ 'env_keep += "SSH_AUTH_SOCK"' ]
  }

# for multiple users in one shot and set their shell to zsh
  ohmyzsh::install { ['root', 'ravery']: set_sh => true, disable_auto_update => true }
  ohmyzsh::theme { ['root', 'ravery']: theme => 'dpoggi' }
}