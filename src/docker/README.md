# Docker for development

## Included

- PostgreSQL 13
- SQL Server 2019
- MySQL 8.0
- Oracle Database 21c XE
- MailHog

## Usage

```
$ docker-compose up -d
```

```
$ docker-compose down
```

## Config

### PostgreSQL

#### .env

```
database.default.hostname = localhost
database.default.database = test
database.default.username = postgres
database.default.password = postgres
database.default.DBDriver = Postgre
database.default.port     = 5432
```

### SQL Server

#### Create Database

```
$ docker-compose exec mssql bash
mssql@aaa8e9411491:/$ /opt/mssql-tools/bin/sqlcmd -S localhost -U SA -P "1Secure*Password1" -Q "CREATE DATABASE test"
```

#### .env

```
database.default.hostname = localhost
database.default.database = test
database.default.username = sa
database.default.password = 1Secure*Password1
database.default.DBDriver = SQLSRV
database.default.port     = 1433
```

See https://docs.microsoft.com/en-us/sql/linux/quickstart-install-connect-docker?view=sql-server-ver15&pivots=cs1-bash

### MySQL

#### .env

```
database.default.hostname = localhost
database.default.database = test
database.default.username = mysql
database.default.password = mysql
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

### Oracle

#### .env

```
NLS_LANG                = 'AMERICAN_AMERICA.UTF8'
NLS_DATE_FORMAT         = 'YYYY-MM-DD HH24:MI:SS'
NLS_TIMESTAMP_FORMAT    = 'YYYY-MM-DD HH24:MI:SS'
NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS'
database.default.DSN      = localhost:1521/XEPDB1
database.default.hostname =
database.default.database =
database.default.username = ORACLE
database.default.password = ORACLE
database.default.DBDriver = OCI8
database.default.charset  = AL32UTF8
database.default.port     = 1521
```

### MailHog

#### .env

```
email.protocol = smtp
email.SMTPHost = localhost
email.SMTPPort = 1025
email.SMTPCrypto =
email.fromEmail = info@example.com
```

Navigate to http://localhost:8025/ to see sent mails.
