class bsl_core::dotfiles::ohmyzsh(
  $users            = $bsl_core::dotfiles::params::users,
  $uninstall_others = $bsl_core::dotfiles::params::uninstall_others,
  $plugins          = ['gitfast', 'colorize'],
) inherits bsl_core::dotfiles::params {
  $incl_root = concat($users, 'root')

  if $uninstall_others {
    ::dotfiles::uninstall{ $incl_root: }
  }

  class { 'ohmyzsh::config': theme_hostname_slug => '%M' }

  package { 'pygmentize':
    ensure   => installed,
    provider => gem,
  }


  # for multiple users in one shot and set their shell to zsh
  ohmyzsh::install { 'root': set_sh => true, disable_auto_update => true }
  ->ohmyzsh::install { $users: set_sh => true, disable_update_prompt => true }
  ->ohmyzsh::plugins { 'root': plugins => $plugins }
  ->ohmyzsh::theme { $incl_root: }
}
