class reubenavery::www::sites::wonderland_works(
  $home = '/srv/wonderland-works-www',
  $docroot = "/srv/wonderland-works-www/drupal",
) inherits reubenavery::params {
  include reubenavery::www

  apache::vhost { 'wonderland-works-www':
    servername          => 'www.wonderland.works',
    serveraliases       => ['wonderland.works'],
    port                => '80',
    docroot             => $docroot,
    override            => 'all',
  }
}