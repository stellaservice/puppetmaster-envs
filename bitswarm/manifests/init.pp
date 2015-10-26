class bitswarm {
  notify { 'hello-world':
    message => "Hello world role=${::puppet_role}"
  }
}