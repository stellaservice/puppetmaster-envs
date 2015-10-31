# == Define: bitswarm::ohmyzsh::install
#
# This is the bitswarm::ohmyzsh module. It installs oh-my-zsh for a user and changes
# their shell to zsh. It has been tested under Ubuntu.
#
# This module is called bitswarm::ohmyzsh as Puppet does not support hyphens in module
# names.
#
# oh-my-zsh is a community-driven framework for managing your zsh configuration.
#
# === Parameters
#
# set_sh: (boolean) whether to change the user shell to zsh
# disable_auto_update: (boolean) whether to prompt for updates bi-weekly
#
# === Authors
#
# Leon Brocard <acme@astray.com>
# Zan Loy <zan.loy@gmail.com>
#
# === Copyright
#
# Copyright 2014
#
define bitswarm::ohmyzsh::install(
  $set_sh              = false,
  $disable_auto_update = false,
) {

  include bitswarm::ohmyzsh::params

  if ! defined(Package['git']) {
    package { 'git':
      ensure => present,
    }
  }

  if ! defined(Package['zsh']) {
    package { 'zsh':
      ensure => present,
    }
  }

  if $name == 'root' {
    $home = '/root'
  } else {
    $home = "${bitswarm::ohmyzsh::params::home}/${name}"
  }

  exec { "ohmyzsh::git clone ${name}":
    creates => "${home}/.oh-my-zsh",
    command => "git clone https://github.com/robbyrussell/oh-my-zsh.git ${home}/.oh-my-zsh || (rmdir ${home}/.oh-my-zsh && exit 1)",
    path    => ['/bin', '/usr/bin'],
    onlyif  => "getent passwd ${name} | cut -d : -f 6 | xargs test -e",
    require => Package['git'],
  }
  ~>
  exec { "ohmyzsh::chown ${name}":
    command => "chown -R ${name}:${name} ${home}/oh-my-zsh",
    path    => ['/bin', '/usr/bin'],
    refreshonly => true,
  }

  exec { "ohmyzsh::cp .zshrc ${name}":
    creates => "${home}/.zshrc",
    command => "cp ${home}/.oh-my-zsh/templates/zshrc.zsh-template ${home}/.zshrc",
    path    => ['/bin', '/usr/bin'],
    onlyif  => "getent passwd ${name} | cut -d : -f 6 | xargs test -e",
    user    => $name,
    require => Exec["ohmyzsh::git clone ${name}"],
    before  => File_Line["ohmyzsh::disable_auto_update ${name}"],
  }

  if $set_sh {
    if ! defined(User[$name]) {
      user { "ohmyzsh::user ${name}":
        ensure     => present,
        name       => $name,
        managehome => true,
        shell      => $bitswarm::ohmyzsh::params::zsh,
        require    => Package['zsh'],
      }
    } else {
      User <| title == $name |> {
        shell => $bitswarm::ohmyzsh::params::zsh
      }
    }
  }

  file_line { "ohmyzsh::disable_auto_update ${name}":
    path  => "${home}/.zshrc",
    line  => "DISABLE_AUTO_UPDATE=\"${disable_auto_update}\"",
    match => '.*DISABLE_AUTO_UPDATE.*',
  }

}
