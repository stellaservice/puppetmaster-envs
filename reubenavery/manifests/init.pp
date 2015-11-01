class reubenavery(
  $srv_home = $reubenavery::params::home,
  $www_user = $reubenavery::params::www_user,
  $db_user  = 'wordpress',
  $db_pass  = 'dok3490vckz',
  $db_root_pw = 'dakos934jkx',
) inherits reubenavery::params {

  include apt

  package { ['build-essential', 'unzip']:
    ensure => installed,
  }

  class { '::mysql::server':
    root_password           => $db_root_pw,
    remove_default_accounts => true,
    purge_conf_dir          => true,
    override_options        => {
      'mysqld'     => {
        datadir => '/srv/mysql',
      },
      'mysqld_safe'=> {
        datadir => '/srv/mysql',
      }
    }
  }
}