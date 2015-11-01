class reubenavery(
  $srv_home = $reubenavery::params::home,
  $www_user = $reubenavery::params::www_user,
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
  $db_root_pw = 'dakos934jkx',
) inherits reubenavery::params {

  include apt

  apt::source { 'backports':
    location    => 'http://us-east-1.ec2.archive.ubuntu.com/ubuntu/',
    key         => '630239CC130E1A7FD81A27B140976EAF437D05B5',
    repos       => 'main restricted universe multiverse',
    include_src => true,
    require     => Class['apt'],
  }

  class { '::mysql::server':
    root_password           => $db_root_pw,
    remove_default_accounts => true,
  }

}