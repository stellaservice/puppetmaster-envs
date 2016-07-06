class bsl_core::dotfiles::yadr(
  $uninstall_others = $bsl_core::params::uninstall_others
) inherits bsl_core::dotfiles::params {
  include '::dotfiles'

  $incl_root = concat($users, 'root')

  if $uninstall_others {
    ::ohmyzsh::uninstall($incl_root)
  }

}

