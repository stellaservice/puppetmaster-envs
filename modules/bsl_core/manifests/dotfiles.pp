class bsl_core::dotfiles(
  $use = $bsl_core::dotfiles::params::dotfiles,
  $uninstall_others = $bsl_core::dotfiles::params::uninstall_others,
) inherits bsl_core::dotfiles::params {
  class { "::bsl_core::dotfiles::$use": uninstall_others => $uninstall_others }
}
