class bitswarm::users {
  user { 'ravery':
    ensure     => present,
    managehome => true,
  }
  ->
  bitswarm::ohmyzsh::install { ['root', 'ravery']: set_sh => true, disable_auto_update => true }
  ->
  bitswarm::ohmyzsh::theme { ['root', 'ravery']: theme => 'dpoggi' }

  ssh_authorized_key { 'ravery@bitswarm.io':
    user => 'ravery',
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAABAQDVIu0Y4jx2hQzeZOlxY1CDYE8exmCxgOE/ZaPLzc6gR7xkYb93PYOGEdRHZS4Vk/oilGOzruN/rNq+Ni4YMuhkrkZKoQalhHX88NUvG8xcePvIMiBdHavdkBzbHOn6qvZlsTFudZFM8BigoJ/iY9TtIyA0YKxCD8tfmbA7gZsd/+R60cxYXd1zx/gMtgmwBqRX1E8z7xfJn01bmJAErkiNkDyq2stbT/Uh8YhI0UmZ/q74Cr/x7R95cBeRjtmlRMMMAtqqqvxbQh3yox4M9XMZpA9Dt2cRdPNbJuhnv+bq444qfTw3vpaVDSqxdcuRGHPjbIH2W2sA6beifJ3Ozx1D',
  }

  ssh_authorized_key { 'reubenavery@gmail.com':
    user => 'ravery',
    type => 'ssh-rsa',
    key  => 'AAAAB3NzaC1yc2EAAAADAQABAAABAQDxBGMmBih454ng98CUjgTfW/j2f38WIgYgCYJUeEjs9Ovwmbz8ZVSYZ449txUB5z6hjaEG+/Fb1jrqXVqLWnLDgcDtCmayQD+3vUq2vTHPnaDILodssx7t8CWOOxEWVjXEI2OhHZSREQxci1u4u5PbiIgoA1vTLLCJwqLrfESaDqR2eF7ATHd83eKZrx4hCIZlEwjaIemQiQVYEvJ2XYCeBEg5U967k+5NS3kqnhObtqlEL4xzmtxBvqeOrL5Iwe9+qNXJG4rems54PXAnzp4ANdkFtXeJHbAcivD4NXgBk1NtPUCSB/kPKSlN9cgOOYf/cJDW4b0Cp3KZXOuZcJ6P',
  }

  sudo::sudoers { 'sysops':
    ensure   => 'present',
    users    => ['ravery'],
    runas    => ['root'],
    cmnds    => ['ALL'],
    tags     => ['NOPASSWD'],
    defaults => [ 'env_keep += "SSH_AUTH_SOCK"' ]
  }
}