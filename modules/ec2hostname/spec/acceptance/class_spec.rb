require 'spec_helper_acceptance'

describe 'ec2hostname' do

  context 'server' do

    it 'should work idempotently with no errors' do
      pp = <<-EOS
      class { 'ec2hostname':
        aws_key     => 'ABCDE',
        aws_secret  => 'FGHIJKL',
        zone        => 'us-east-1',
        install_gem => true
      }
      EOS

      # Run it twice and test for idempotency
      apply_manifest(pp, :catch_failures => true)
      apply_manifest(pp, :catch_changes  => true)
    end

    describe service('ec2hostname') do
      it { is_expected.to be_enabled }
      it { is_expected.to be_running }
    end

  end # server

end
