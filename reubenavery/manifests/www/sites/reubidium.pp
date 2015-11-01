class reubenavery::www::sites::reubidium(
  $home = '/srv/reubidium-www',
  $docroot = "/srv/reubidium-www/drupal",
  $db_host = 'localhost',
  $db_name = 'reubidium_d6',
  $db_user = 'reubidium',
  $db_password = 'fdklqoi49d',
  $create_db = true,
  $create_db_user = true,
) inherits reubenavery::params {
  include reubenavery::www

  if $create_db {
    mysql_database { "${db_host}/${db_name}":
      name => $db_name,
      charset => 'utf8',
    }
  }
  if $create_db_user {
    mysql_user { "${db_user}@${db_host}":
      password_hash => mysql_password($db_password),
    }
    mysql_grant { "${db_user}@${db_host}/${db_name}.*":
      table      => "${db_name}.*",
      user       => "${db_user}@${db_host}",
      privileges => ['ALL'],
    }
  }

  apache::vhost { 'reubidium-www':
    servername          => 'www.reubidium.com',
    serveraliases       => ['reubidium.com'],
    port                => '80',
    docroot             => $docroot,
    override            => 'all',
  }

  file { "$docroot/sites/default/settings.php":
    content => template('reubenavery/d6-settings.erb')
  }
}