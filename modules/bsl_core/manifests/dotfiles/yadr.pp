class bsl_core::dotfiles::yadr(
  $users            = $bsl_core::dotfiles::params::users,
  $uninstall_others = $bsl_core::dotfiles::params::uninstall_others
) inherits bsl_core::dotfiles::params {
  $incl_root = concat($users, ['root'])

  if $uninstall_others {
    ::ohmyzsh::uninstall { $incl_root: }
  }

  class { '::dotfiles':
    manage_git => false,
  }

  # for multiple users in one shot and set their shell to zsh
  dotfiles::install { $incl_root: set_sh => true }
}

