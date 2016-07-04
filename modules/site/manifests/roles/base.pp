class site::roles::base(
  $timezone = 'America/New_York',
) {
  anchor { '::site::roles::base': }

  info("## hello clientcert ${::clientcert}")

  Class {
    require => Anchor['::site::roles::base'],
  }

  class { '::ntp': }

  class { '::timezone':
    timezone => $timezone,
  }

  class { '::puppet::agent':
    puppet_server => 'puppet.bitswarm.io',
    reportserver => 'puppet.bitswarm.io',
  }

  sshkey { 'github.com':
    key    => 'AAAAB3NzaC1yc2EAAAABIwAAAQEAq2A7hRGmdnm9tUDbO9IDSwBK6TbQa+PXYPCPy6rbTrTtw7PHkccKrpp0yVhp5HdEIcKr6pLlVDBfOLX9QUsyCOV0wzfjIJNlGEYsdlLJizHhbn2mUjvSAHQqZETYP81eFzLQNnPHt4EVVUh7VfDESU84KezmD5QlWpXLmvU31/yMf+Se8xhHTvKSCZIFImWwoG6mbUoWf9nzpIoaSjB+weqqUUmpaaasXVal72J+UX2B+2RPW3RcT0eOzQgqlJL3RKrTJvdsjE3JEAvGq3lGHSZXy28G3skua2SmVi/w4yCE6gbODqnTWlg7+wC604ydGXA8VJiS5ap43JXiUFFAaQ==',
    target => '/etc/ssh/ssh_known_hosts',
    type   => 'ssh-rsa',
  }
}