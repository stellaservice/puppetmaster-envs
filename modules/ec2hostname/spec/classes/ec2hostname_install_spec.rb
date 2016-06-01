require 'spec_helper'

describe 'ec2hostname' do
  context 'CentOS 6' do
    let(:facts) { { :osfamily => 'Redhat', :operatingsystemmajrelease => '6' } }

    context 'not installing gems (default)' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1' } }
      it { should_not contain_package('aws-sdk') }
    end

    context 'installing gems' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1', :install_gem => true } }
      it { should contain_package('ruby-devel') }
      it { should contain_package('aws-sdk').with(:provider => 'gem') }
    end
  end

  context 'Centos 7' do
    let(:facts) { { :osfamily => 'Redhat', :operatingsystemmajrelease => '7' } }

    context 'not installing gems (default)' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1' } }
      it { should_not contain_package('aws-sdk') }
    end

    context 'installing gems' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1', :install_gem => true } }
      it { should contain_package('ruby-devel') }
      it { should contain_package('aws-sdk').with(:provider => 'gem') }
    end
  end

  context 'Ubuntu 12.04' do
    let(:facts) { { :osfamily => 'Debian', :lsbmajdistrelease => '12.04' } }

    context 'not installing gems (default)' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1' } }
      it { should_not contain_package('aws-sdk') }
    end

    context 'installing gems' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1', :install_gem => true } }
      it { should contain_package('rubygems') }
      it { should contain_package('aws-sdk').with(:provider => 'gem') }
    end
  end

  context 'Ubunto 14.04' do
    let(:facts) { { :osfamily => 'Debian', :lsbmajdistrelease => '14.04' } }

    context 'not installing gems (default)' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1' } }
      it { should_not contain_package('aws-sdk') }
    end

    context 'installing gems' do
      let(:params) { { :aws_key => 'a', :aws_secret => 'b', :zone => 'us-east-1', :install_gem => true } }
      it { should contain_package('ruby-dev') }
      it { should contain_package('aws-sdk').with(:provider => 'gem') }
    end
  end

end
