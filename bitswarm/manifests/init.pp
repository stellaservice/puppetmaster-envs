class bitswarm(
  $derp = 'derpisty'
) {
  notify { 'hello-world':
    message => "Hello world ${derp} role=${::puppet_role}"
  }
}