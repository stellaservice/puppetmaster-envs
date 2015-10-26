class site::roles::packages {
  anchor { '::site::roles::packages': }

  package { 'zsh': }
  package { 'git': }
  hiera_include('classes')
}