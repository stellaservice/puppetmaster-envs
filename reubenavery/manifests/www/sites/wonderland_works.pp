class reubenavery::www::sites::wonderland_works(
  $home = '/srv/wonderland-works-www',
  $docroot = "/srv/wonderland-works-www/drupal",
  $db_host = 'localhost',
  $db_name = 'wonderland_d7',
  $db_user = 'wonderland',
  $db_password = 'xczxc34fsd',
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

  apache::vhost { 'wonderland-works-www':
    servername          => 'www.wonderland.works',
    serveraliases       => ['wonderland.works'],
    port                => '80',
    docroot             => $docroot,
    override            => 'all',
  }

  file { "$docroot/sites/default/settings.php":
    content => template('reubenavery/d7-settings.erb')
  }
}