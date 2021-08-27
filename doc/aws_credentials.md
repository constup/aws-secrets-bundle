# AWS credentials and authentication

## Local development environment (bare metal)

If you don't already have AWS CLI installed on your computer, download and install it. If you need help with downloading
and installing AWS CLI, read the official AWS documentation: 
[Installing, updating, and uninstalling AWS CLI](https://docs.aws.amazon.com/cli/latest/userguide/cli-chap-install.html).

Configure your AWS connection credentials by running:

```shell
aws configure
```

More instructions can be found in the official AWS documentation: 
[Quick configuration with aws configure](https://docs.aws.amazon.com/cli/latest/userguide/cli-configure-quickstart.html#cli-configure-quickstart-config) 

AWS SDK should now be able to pick up credentials from your `~/.aws` user directory.

## AWS EC2 instance

EC2 instances should already have all the necessary connections to other AWS services preconfigured.
If you are running a Symfony application which uses this bundle on an EC2 instance, you probably don't
need to configure anything.

**!!NOTE!!** :
This is **NOT** tested at the moment.

## Docker container built with AWS CodeBuild

Add `AWS_CONTAINER_CREDENTIALS_RELATIVE_URI` environment variable value into your Docker container during `docker build`.
To do that, modify your `buildspec.yml` file to something like this:

```yaml
phases:
    build:
        commands:
            ...
            docker build --build-arg AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=$AWS_CONTAINER_CREDENTIALS_RELATIVE_URI -t myapp:latest . 
```

Then add it as an argument in your `Dockerfile`:

```dockerfile
ARG AWS_CONTAINER_CREDENTIALS_RELATIVE_URI
```

That's it! AWS SDK will handle the rest. The app in your Docker container can now connect to AWS services 
(including Secrets Manager) by using AWS metadata service to retrieve credentials from an IAM role.

Want to know how this works and why we're explicitly using `AWS_CONTAINER_CREDENTIALS_RELATIVE_URI` environment 
variable? Then read the following (3rd party) blog post: [Use an IAM Role in a Container in AWS CodeBuild](https://blog.jwr.io/aws/codebuild/container/iam/role/2019/05/30/iam-role-inside-container-inside-aws-codebuild.html)

---
[[Back to README](../README.md)]