require 'spec_helper'

describe 'ec2hostname' do
  let(:facts) { { :osfamily => 'RedHat', :operatingsystemmajrelease => '7' } }

  context 'default' do
    let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1' } }
    it { should contain_service('ec2hostname').with(
      :ensure => 'running',
      :enable => true
    ) }
  end

  context 'configure service settings' do
    let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1', :service => 'stopped', :enable => false } }
    it { should contain_service('ec2hostname').with(
      :ensure => 'stopped',
      :enable => false
    ) }
  end
end