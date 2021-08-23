# AWS Secrets Bundle

[![GitHub license](https://img.shields.io/github/license/constup/aws-secrets-bundle?style=flat-square&color=green)](https://github.com/constup/aws-secrets-bundle/blob/master/LICENSE)
![PHP version](https://img.shields.io/badge/PHP-%5E7.4-blueviolet?style=flat-square)
![Symfony](https://img.shields.io/badge/Symfony-%5E5.3-blueviolet?style=flat-square)

Use AWS Secrets as service container parameters in Symfony.

## History and honorable mentions

This bundle is loosely based and inspired by `incompass/aws-secrets-bundle` (https://github.com/casechek/aws-secrets-bundle). 
The Incompass bundle is compatible with Symfony 3 and 4, and it looks like it's not updated/maintained anymore. This 
package is built to be compatible with Symfony 5 and will, over time, get improvements.

If you are still using Symfony 3 or 4, please use the Incompass bundle instead of this one.

## Installation

    $ composer require constup/aws-secrets-bundle

## Configuration

```yaml
aws_secrets:
  client_config:
    region:           # required if ignore is false
    version: 'latest' # defaults to latest
    credentials: 
        key: ~
        secret: ~
  cache: 'array'      # one of apcu, array, filesystem, default is array
  delimiter: ','      # delimiter to separate key from secret name
  ignore: false       # pass through aws (for local dev environments set to true)
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
