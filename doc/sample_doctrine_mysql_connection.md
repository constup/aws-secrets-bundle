# Example: Configure Doctrine in Symfony to use AWS Secret values as MySQL connection parameters

Let's say that we have an AWS Secret named `server_config` in JSON format which contains our database connection 
credentials.

```json
{
    "database_username": "some_username",
    "database_password": "some_password"
}
```

Let's use the contents of this secret as database connection parameters in Symfony.

# Step #1: Create environment variables

Create environment variables (in your Symfony `.env` file) called `DATABASE_USERNAME` and `DATABASE_PASSWORD`.
The values of these environment variables are made of the name of your AWS Secret, a delimiter and the name of
the entry within the secret:
```dotenv
DATABASE_USERNAME='server_config','database_username'
DATABASE_PASSWORD='server_config','database_password'
```

# Step #2: Load secrets in service container parameters 

Add the following to `config/services.yaml`:

```yaml
parameters:
    ...
    database_username: '%env(aws:DATABASE_USERNAME)%'
    database_password: '%env(aws:DATABASE_PASSWORD)%'
```

Now, when you call:

```php
$this->getParameter('database_username');
```

in a controller, this bundle will apply AWS processor to `database_username` parameter and use AWS SDK to fetch the 
value from the AWS Secret Manager.

# Step #3: Configure Doctrine's MySQL connection

By default, Doctrine stores database connection parameters in the `DATABASE_URL` environment variable 
(in the `.env` file). It should look something like this:

```dotenv
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0"
```

To load database username and password which we fetched from the AWS Secrets Manager, just use the `database_username` 
and `database_password` service container parameters in the above line:

```dotenv
DATABASE_URL="mysql://%database_username%:%database_password%@127.0.0.1:3306/db_name?serverVersion=8.0"
```

If you are using AWS RDS for database, also replace `127.0.0.1` with your RDS endpoint. _(Hint: you can also store this 
value in your `server_config` secret and fetch it just like username and password.)_
