# == Define: bitswarm::ohmyzsh::theme
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
define bitswarm::ohmyzsh::theme(
  $theme = 'clean',
) {

  include bitswarm::ohmyzsh::params

  if $name == 'root' {
    $home = '/root'
  } else {
    $home = "${bitswarm::ohmyzsh::params::home}/${name}"
  }

  file_line { "${name}-${theme}-install":
    path    => "${home}/.zshrc",
    line    => "ZSH_THEME=\"${theme}\"",
    match   => '^ZSH_THEME',
    require => Ohmyzsh::Install[$name]
  }

}
