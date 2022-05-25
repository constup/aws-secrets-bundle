# AWS Secrets Bundle

[![GitHub license](https://img.shields.io/github/license/constup/aws-secrets-bundle?style=flat-square&color=green)](https://github.com/constup/aws-secrets-bundle/blob/master/LICENSE)
![PHP version](https://img.shields.io/badge/PHP-%5E7.4-blueviolet?style=flat-square)
![Symfony](https://img.shields.io/badge/Symfony-%5E5.3-blueviolet?style=flat-square)

Use AWS Secrets as service container parameters in Symfony.

## History and honorable mentions

This bundle is loosely based on and inspired by `incompass/aws-secrets-bundle` (https://github.com/casechek/aws-secrets-bundle). 
The Incompass bundle is compatible with Symfony 3 and 4, and it looks like it's not updated/maintained anymore. This 
package is built to be compatible with Symfony 5 and will, over time, get improvements.

If you are still using Symfony 3 or 4, please use the Incompass bundle instead of this one.

## Prerequisites

### Install AWS SDK

Since the official recommendation from Symfony is: `A bundle must not embed third-party PHP libraries. 
It should rely on the standard Symfony autoloading instead.`, the `aws/aws-sdk-php` Composer package is included in this 
bundle only as a dev dependency (for testing purposes).

You need to install AWS SDK for PHP in your project yourself:

```shell
composer require aws/aws-sdk-php
```

### AWS credentials

In order to connect to any AWS service (for example: AWS Secrets Manager), your application must be authenticated on 
that AWS service. Since there are several scenarios for this, depending on your environment setup, configuring 
environments and using credentials is covered here: [AWS credentials and authentication](./doc/aws_credentials.md)

## Installation

There are two main versions of AWS Secrets bundle: 1.x and 2.x.

Install version 1.x to use this package with Symfony 5.x and PHP 7.4.

    $ composer require constup/aws-secrets-bundle:^1

Install version 2.x to use this package with Symfony 6.x and PHP 8.x.

    $ composer require constup/aws-secrets-bundle:^2

## Configuration

By default, configuration for this bundle is loaded from `config/packages/aws_secrets.yaml` file or its 
environment-specific alternatives (for example: `config/packages/test/aws_secrets.yaml`). The following configuration
properties are available:

```yaml
aws_secrets:
  client_config:
    region:           # Required if "ignore" is false.
    version: 'latest' # Defaults to "latest".
    endpoint: ~
    credentials: 
        key: ~
        secret: ~
  cache: 'array'      # Can be one of the following: apcu, array, filesystem. Default is array.
  delimiter: ','      # Delimiter to separate key from secret name.
  ignore: false       # Pass through AWS (for local dev environments set to "true").
```

## Usage

Set an env var to an AWS Secret Manager Secret name like so:

    AWS_SECRET=secret_name

If you want to grab a key in a JSON secret, you can separate the secret name and key:

    AWS_SECRET=secret_name,key
    
Set a parameter to this environment variable with the aws processor:

```yaml
parameters:
    my_parameter: '%env(aws:AWS_SECRET)%'
```

Your secret will now be loaded at runtime!

## Examples

* [Configure Doctrine to use AWS Secret values as MySQL connection parameters](./doc/sample_doctrine_mysql_connection.md)
