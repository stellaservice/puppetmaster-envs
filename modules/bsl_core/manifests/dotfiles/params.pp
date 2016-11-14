class bsl_core::dotfiles::params {
  $users = unique(hiera('manage_dotfiles_for', [$bsl_core::service_acct]))
  $dotfiles = 'disabled'
  $uninstall_others = false
}
