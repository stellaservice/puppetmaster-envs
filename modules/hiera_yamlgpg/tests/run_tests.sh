#!/usr/bin/env bash --login
#
# Tested On Mac OSX 10.10

rvm use ruby 1.9.3 || rvm install ruby 1.9.3
rvm use ruby 1.9.3
rvm gemset create hiera_yamlgpg
rvm gemset use hiera_yamlgpg
gem install hiera -v 1.2.1
gem install gpgme -v 2.0.2
for key in `cat hieradata/secrets.yaml | grep "^[a-z]" | cut -f1 -d":"`; do bash -c "RUBYLIB=../lib hiera -c hiera.yaml ${key}"; done

# Now, testing ruby_gpg support

rvm gemset create hiera_yamlgpg-ruby_gpg
rvm gemset use hiera_yamlgpg-ruby_gpg
gem install hiera -v 1.2.1
gem install ruby_gpg
for key in `cat hieradata/secrets.yaml | grep "^[a-z]" | cut -f1 -d":"`; do bash -c "RUBYLIB=../lib hiera -c hiera.yaml ${key}"; done
