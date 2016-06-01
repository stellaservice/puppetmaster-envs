require 'spec_helper'

describe 'ec2hostname', :type => :class do
  let(:facts) { { :osfamily => 'Redhat', :operatingsystemmajrelease => '7' } }
  let(:params) { {
    :aws_key    => "abc",
    :aws_secret => "def",
    :hostname   => "myhost",
    :domain     => "mydomain.com",
    :ttl        => 60,
    :type       => "CNAME",
    :target     => "local-hostname",
    :zone       => "123",
  } }

  context 'install the init script' do
    it { should contain_file('/etc/sysconfig/ec2hostname') }
  end
end
