class reubenavery::www::sites::endarus(
  $home = '/srv/endarus-www',
  $docroot = "/srv/endarus-www/html",
) inherits reubenavery::params {
  include reubenavery::www

  apache::vhost { 'endarus-www':
    servername          => 'www.endarus.com',
    serveraliases       => ['endarus.com'],
    port                => '80',
    docroot             => $docroot,
  }
}