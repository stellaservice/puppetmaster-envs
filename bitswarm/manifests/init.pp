class bitswarm(
  $derp = undef
) {
  if $derp and $derp != '' {
    notify { "bitswarm-derp":
      message => "## bitswarm derp= $derp"
    }
  }
}