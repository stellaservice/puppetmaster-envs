#ec2hostname

####Table of Contents

1. [Overview](#overview)
2. [Module Description](#module-description)
3. [Setup](#setup)
    * [What ec2hostname affects](#what-ec2hostname-affects)
    * [Setup requirements](#setup-requirements)
    * [Beginning with ec2hostname](#beginning-with-ec2hostname)
4. [Usage - Configuration options and additional functionality](#usage)
    * [Parameters](#parameters)
    * [IAM Config](#iam-config)
5. [Limitations](#limitations)
6. [Development](#development)
7. [Release Notes](#release-notes)
8. [License](#license)
9. [Acknowledgements](#acknowledgements)


##Overview

Adds hostname registration for AWS VPC nodes to a private Route53 zone.

##Module Description

This module installs an init script that handles start, restart, stop, and status.  Starting (or restarting) the init script will ensure the node exists in the private zone specified.  Stopping the module will remove it from the zone.

##Setup

###What ec2hostname affects

* Adds an init script for name registration

###Setup Requirements

* aws-sdk ruby gem (can be installed by the module with the install_gem parameter)
* stdlib puppet module
* nodes using this module must be in an EC2 VPC
* IAM policy allowing Route53 updates (see [Usage](#usage))
###Beginning with ec2hostname

To install the module:
    puppet module install evenup-java

Required parameters are: aws_key, aws_secret, and zone.  See [Usage](#usage) for descriptions.

##Usage

###Parameters
#####`aws_key`
The AWS key used to make Route53 updates

#####`aws_secret`
The AWS secret for aws_key

#####`zone`
The Hosted Zone ID for the private zone to update

#####`install_gem`'
Whether or not the aws-sdk ruby gem should be installed.  Valid values are true and false. The default value is false

#####`hostname`
The hostname that should be used for this node.  The default value is 'hostname' from facter.

#####`domain`
The domain name that should be appended to the hostname.  The default value is 'domain' from facter.

#####`ttl`
The TTL (in seconds) that should be associated with this record.  Valid values are integers.  The default value is 60.

#####`type`
The type of record that should be added for this node.  Valid values are A and CNAME.  The default value is CNAME.

#####`target`
The answer portion of the record entry.  Typically this would be an IP address for an A record or an A record for a CNAME.
If this is set to 'local-hostname' (the default), the AWS meta-data service will be queried for the local-hostname parameter.
If this is set to 'local-ipv4, the AWS meta-data service will be queried for the local-ipv4 parameter.

#####`service`
Whether or not the ec2hostname service should be running.  Valid values are true or false.  The default is true.

#####`enable`
Whether or not the ec2hostname service should be enabled at boot.  Valid values are true or false.  The default is true.

###IAM Config
It is HIGHLY recommeded to use an IAM user with limited to access for this service.  The permissions needed for this user are:

```
  {
    "Version": "2012-10-17",
    "Statement": [
      {
        "Sid": "Stmt1415820843000",
        "Effect": "Allow",
        "Action": [
          "route53:ChangeResourceRecordSets",
          "route53:GetHostedZone",
          "route53:ListResourceRecordSets"
        ],
        "Resource": [
          "arn:aws:route53:::hostedzone/<your hosted zone id>"
        ]
      }
    ]
  }
```

##Limitations

CentOS/RHEL 6 tested

##Development

Pull requests are greatly appreciated!
* Fork it
* Create a topic branch
* Improve/fix (with spec tests)
* Push new topic branch
* Submit a PR

## Release Notes
See the [CHANGELOG](https://github.com/evenup/evenup-ec2hostname/blob/master/CHANGELOG)

## License
Released under the Apache 2.0 license

## Acknowledgements
The init script used here is based heavily on a [gist](https://gist.github.com/kixorz/81287bb06dbc5e16e96b) by @kixorz.
