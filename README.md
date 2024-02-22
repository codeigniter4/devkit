# CodeIgniter DevKit

Development toolkit for CodeIgniter libraries and projects

## Installation

Install via Composer:

```console
composer config minimum-stability dev
composer config prefer-stable true
composer require --dev codeigniter4/devkit
```

## Included Dependencies

### Styles and Standards

* [CodeIgniter Coding Standard](https://github.com/CodeIgniter/coding-standard)
* [NexusPHP CS Config](https://github.com/NexusPHP/cs-config)

### Testing and Analysis

* [NexusPHP Tachycardia](https://github.com/NexusPHP/tachycardia)
* [PHPStan](https://phpstan.org/user-guide/getting-started)
* [PHPUnit](https://phpunit.readthedocs.io)
* [Psalm](https://psalm.dev)

### Mocking

* [FakerPHP](https://fakerphp.github.io)
* [VFS Stream](https://github.com/bovigo/vfsStream/wiki)

### Security

* [Dependabot](https://docs.github.com/en/code-security/supply-chain-security/keeping-your-dependencies-updated-automatically/about-dependabot-version-updates)
* [Roave Security Advisories](https://github.com/Roave/SecurityAdvisories)

### Additional Tools

These are integrated into the workflows but not included via Composer. If you want to use them
locally they will need to be installed. All of them (except Rector) are available via [Phive](https://phar.io/#Tools).

* [Composer Normalize](https://github.com/ergebnis/composer-normalize)
* [Composer Unused](https://github.com/composer-unused/composer-unused)
* [Deptrac](https://github.com/qossmic/deptrac)
* [Infection](https://infection.github.io/)
* [PHP Coveralls](https://php-coveralls.github.io/php-coveralls/)
* [PHP CS Fixer](https://cs.symfony.com/)
* [Rector](https://github.com/rectorphp/rector/)

## Template Files

The provided source files (in **Template/**) should be considered guidelines for your own use,
as they may need changing to fit your environment. These are based on the following assumptions:

1. Your default repository branch is set to `develop`
2. You use Composer to manage all necessary dependencies
3. Your source code is located in **app/** (for projects) or **src/** (for libraries)
4. Your unit tests are located in **tests/**
5. Your CodeIgniter dependency is `codeigniter4/framework` (some paths need to be changed for `dev-develop`)

### Workflows

This kit includes a number of workflow templates for integrating [GitHub Actions](https://docs.github.com/en/actions)
into your library or project development process. To add these to your repo simply copy the
workflows into a **Template/.github/workflows/** directory.

> [!TIP]
> The [source files](src/.github) also include a configuration for Dependabot which
> will help keep your dependencies and workflows updated.

Below is a brief description of each workflow; see the links above for help with each tool.

#### Deptrac

*Requires **depfile.yaml***

Deptrac is a "dependency tracing" tool that allows developers to define which components should
be allowed to access each other. This helps keep your project architecture logical and concise
by enforcing the rules you set. For example, you may want to impose an MVC-style architecture
by allowing a `Controller` to use any `Model` but not vice-versa.

#### Infection

*Requires **infection.json.dist***

Just because your tests reach a high level of code coverage does not mean they are comprehensive.
Mutation Testing is a way of gauging the *quality* of your unit tests. A silly example: your
code has an increment function with a single unit test for 100% coverage:

```php
function increment(int $num1, int $num2): int
{
    return $num1 + $num2;
}

function testIncrementWithZero()
{
    $result = increment(42, 0);
    $this->assertSame(42, $result);
}
```

Infection will re-run your unit test against "mutated" versions of your code that *should*
cause failures and report "escaped mutations" when they still pass. In this example, Infection
mutates your `increment()` function to use `-` instead of `+`, but since your test case
still asserts `42` as the result it is considered an "escape" and you should plan to add
more tests.

#### PHPCPD

PHP Copy-Paste Detector analyzes your code and reports when there are blocks of duplicate code
more than a certain number of lines long (default: 5). In most cases this is a sign of poor
code structure and an opportunity to consolidate classes or functions.

#### PHP CS Fixer

PHP CS Fixer is used to enforce coding standards. Once the rules are defined in the config file
the workflow will check your code against the definitions and fail for any deviance.

#### PHPStan

*Requires **phpstan.neon.dist***

Static analysis is a major factor in catching bugs and issues before they happen. PHPStan will
analyze your code for mistakes based on the configuration supplied.

#### PHPUnit

*Requires **phpunit.xml.dist***

Unit testing automates running your code through all the possible scenarios before putting it
into use in production. PHPUnit is a highly-configurable framework and suite for writing and
running unit tests. This workflow also configures PHPUnit to report on code coverage and
upload the results to [Coveralls.io](https://coveralls.io) (you will need a free account,
but it is also fine to use this workflow without Coveralls).

#### Rector

*Requires **rector.php***

Rector provides automated refactoring of code, allowing you to make sweeping updates based on
predefined rulesets. Rector can be highly opinionated based on its configuration file (**rector.php**)
so be sure to read the documentation and figure out the best fit for you. This workflow performs
a "dry run" to check for any changes that Rector would have made and fail if there are matches.

> [!NOTE]
> Rector updates rules all the time, so you may want to lock your repo to
> the latest known working version of Rector to prevent unexpected failures.
> Using pinned version in `composer.json` and update it with dependabot is the
> best practice.

#### Unused

Composer Unused does one thing: checks that your code actually uses the dependencies you
have included via Composer. It can be easy to forget to update your **composer.json** when
your code drops a dependency, so this workflow will help track those down.

### Hosting with Vagrant

> [!NOTE]
> The `Vagrantfile.dist` is unmaintained. It might not work now.
> Contributions are welcome.

Virtualization is an effective way to test your webapp in the environment you
plan to deploy on, even if you develop on a different one.
Even if you are using the same platform for both, virtualization provides an
isolated environment for testing.

The codebase comes with a **src/Template/Vagrantfile.dist**, that can be copied to **Vagrantfile**
and tailored for your system, for instance enabling access to specific database or caching engines.

#### Setting Up

It assumes that you have installed [VirtualBox](https://www.virtualbox.org/wiki/Downloads) and
[Vagrant](https://www.vagrantup.com/downloads.html)
for your platform.

The Vagrant configuration file assumes you have set up a [ubuntu/bionic64 Vagrant box](https://app.vagrantup.com/ubuntu/boxes/bionic64) on your system:

```console
> vagrant box add ubuntu/bionic64
```

#### Testing

Once set up, you can then launch your webapp inside a VM, with the command:

```console
> vagrant up
```

Your webapp will be accessible at http://localhost:8080, with the code coverage
report for your build at http://localhost:8081 and the user guide for
it at http://localhost:8082.

## Example Files

Besides the template files, this repo includes some examples for integrating CodeIgniter
with other third-party resources. These files (in **Examples/**) may change over time and
should not be relied on for anything more than a reference for your own code.
