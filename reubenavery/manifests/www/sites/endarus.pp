class reubenavery::www::sites::endarus(
  $home = '/srv/endarus-www',
  $docroot = "/srv/endarus-www/docroot",
) inherits reubenavery::params {
  include reubenavery::www

}