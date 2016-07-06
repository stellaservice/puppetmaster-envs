class bsl_core::dotfiles::disabled(
  $uninstall_others = $bsl_core::params::uninstall_others
) inherits bsl_core::dotfiles::params {
  include '::dotfiles'

  if $uninstall_others {
    ::dotfiles::uninstall { $incl_root: }
    ::ohmyzsh::uninstall { $incl_root: reset_sh => false }
  }
}

