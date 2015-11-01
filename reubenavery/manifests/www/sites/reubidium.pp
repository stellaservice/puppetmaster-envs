class reubenavery::www::sites::reubidium(
  $home = '/srv/reubidium-www',
  $docroot = "/srv/reubidium-www/drupal",
) inherits reubenavery::params {
  include reubenavery::www

  apache::vhost { 'reubidium-www':
    servername          => 'www.reubidium.com',
    serveraliases       => ['reubidium.com'],
    port                => '80',
    docroot             => $docroot,
    override            => 'all',
  }
}