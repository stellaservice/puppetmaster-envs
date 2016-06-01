require 'spec_helper'

describe 'ec2hostname', :type => :class do
  let(:facts) { { :osfamily => 'RedHat', :operatingsystemmajrelease => '7' } }
  let(:params) { { :aws_key => 'abc', :aws_secret => 'efg', :zone => '123' } }

  it { should create_class('ec2hostname') }

  it { should contain_class('ec2hostname::install') }
  it { should contain_class('ec2hostname::config') }
  it { should contain_class('ec2hostname::service') }

  context 'fail if ttl is not an integer' do
    let(:params) { { :aws_key => 'abc', :aws_secret => 'efg', :zone => '123', :ttl => 'foo' } }
    it { expect { should create_class('sensu') }.to raise_error() }
  end

  context 'fail if service is invalid' do
    let(:params) { { :aws_key => 'abc', :aws_secret => 'efg', :zone => '123', :service => 'foo' } }
    it { expect { should create_class('sensu') }.to raise_error() }
  end

  context 'fail if type is invalid' do
    let(:params) { { :aws_key => 'abc', :aws_secret => 'efg', :zone => '123', :type => 'foo' } }
    it { expect { should create_class('sensu') }.to raise_error() }
  end

end

