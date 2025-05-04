# Dnd_OffersBanner module


## Description

The Magento 2 Offers module allows you to manage offer banners assigned to one or more categories. It includes a back-office menu to manage offers and displays the offers on the chosen categories in the front-office based on the start and end display dates.


## Installation

To install this module via Composer, execute the following commands:

```sh
composer require dnd/module-offers-banner
bin/magento module:enable Dnd_OffersBanner
bin/magento setup:upgrade
bin/magento setup:di:compile
```

For information about a module installation in Magento 2, see [Manage third-party extensions](https://experienceleague.adobe.com/en/docs/commerce-operations/installation-guide/tutorials/extensions).


## Store Configuration

At Stores > Configuration > Catalog > Catalog > Offers banner:

* **Enabled**


## Manage Offers

At Marketing > Offers banner

## Extensibility

Extension developers can interact with the Dnd_OffersBanner module. For more information about the Magento extension mechanism, see [Magento plug-ins](https://developer.adobe.com/commerce/php/development/components/plugins/).

[The Magento dependency injection mechanism](https://developer.adobe.com/commerce/php/development/build/dependency-injection-file/) enables you to override the functionality of the Dnd_OffersBanner module.


## Running Unit and Integration Tests

### 1. Prerequisites
To run unit and integration tests for the Dnd_OffersBanner module, ensure you have the following:

- Magento 2 environment set up (with dependencies installed).
- PHPUnit installed (Magento 2 uses PHPUnit for testing).
- A dedicated testing database configured.

---

### 2. Configure Test Database

Before running tests, configure a test database for Magento's testing framework:
- Create a Test Database:

    In MySQL, create a new database for testing:
    
```bash
CREATE DATABASE magento_integration_tests;
```
    
- Configure the Test Database:

    Copy the install-config-mysql.php.dist file from dev/tests/integration/etc directory to dev/tests/integration/etc/install_config_mysql.php, and update the database configuration for the test environment. 

    Example configuration:
```php
        return [
            'db-host' => 'localhost',
            'db-user' => 'magento',
            'db-password' => 'magento',
            'db-name' => 'magento_integration_tests',
            'backend-frontname' => 'backend',
            'search-engine' => 'opensearch',
            'opensearch-host' => 'opensearch',
            'opensearch-port' => 9200,
            'admin-user' => \Magento\TestFramework\Bootstrap::ADMIN_NAME,
            'admin-password' => \Magento\TestFramework\Bootstrap::ADMIN_PASSWORD,
            'admin-email' => \Magento\TestFramework\Bootstrap::ADMIN_EMAIL,
            'admin-firstname' => \Magento\TestFramework\Bootstrap::ADMIN_FIRSTNAME,
            'admin-lastname' => \Magento\TestFramework\Bootstrap::ADMIN_LASTNAME,
            'amqp-host' => 'rabbitmq',
            'amqp-port' => '5672',
            'amqp-user' => 'guest',
            'amqp-password' => 'guest',
        ]
```

- Ensure Database Configuration is Correct:
    
  Magento will use this configuration when running tests, ensuring the tests are executed on the test database.

---

### 3. Run Unit Tests

- Copy the phpunit.xml.dist file from dev/tests/unit directory to dev/tests/unit/phpunit.xml, and update the configuration for the test environment.

    Example:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.3/phpunit.xsd"
         colors="true"
         columns="max"
         beStrictAboutTestsThatDoNotTestAnything="false"
         bootstrap="./framework/bootstrap.php">
    <testsuites>
        <testsuite name="Dnd_OffersBanner Unit Test Suite">
            <directory>../../../app/code/*/*/Test/Unit</directory>
        </testsuite>
    </testsuites>
    <php>
        <includePath>.</includePath>
        <ini name="memory_limit" value="-1"/>
        <ini name="date.timezone" value="America/Los_Angeles"/>
        <ini name="xdebug.max_nesting_level" value="200"/>
    </php>
    <listeners>
        <listener class="Magento\Framework\TestFramework\Unit\Listener\ReplaceObjectManager"/>
    </listeners>
</phpunit>
```

- To run unit tests, execute the following command from the Magento root directory:

```bash
vendor/bin/phpunit -c $(pwd)/dev/tests/unit/phpunit.xml app/code/Dnd/OffersBanner/Test/Unit/
```

---

### 4. Run Integration Tests

- Copy the phpunit.xml.dist file from dev/tests/integration directory to dev/tests/integration/phpunit.xml, and update the configuration for the test environment.

    Example:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.3/phpunit.xsd"
         colors="true"
         columns="max"
         beStrictAboutTestsThatDoNotTestAnything="false"
         bootstrap="./framework/bootstrap.php"
         stderr="true"
         testSuiteLoaderClass="Magento\TestFramework\SuiteLoader"
         testSuiteLoaderFile="framework/Magento/TestFramework/SuiteLoader.php">
    <testsuites>
        <testsuite name="Dnd_OffersBanner Integration Tests Real Suite">
            <directory>testsuite</directory>
            <directory>../../../app/code/*/*/Test/Integration</directory>
        </testsuite>
    </testsuites>
    <php>
        <includePath>.</includePath>
        <includePath>testsuite</includePath>
        <ini name="date.timezone" value="America/Los_Angeles"/>
        <ini name="xdebug.max_nesting_level" value="200"/>
        <const name="TESTS_INSTALL_CONFIG_FILE" value="etc/install-config-mysql.php"/>
        <const name="TESTS_POST_INSTALL_SETUP_COMMAND_CONFIG_FILE" value="etc/post-install-setup-command-config.php"/>
        <const name="TESTS_GLOBAL_CONFIG_FILE" value="etc/config-global.php"/>
        <const name="TESTS_GLOBAL_CONFIG_DIR" value="../../../app/etc"/>
        <const name="TESTS_CLEANUP" value="disabled"/>
        <const name="TESTS_MEM_USAGE_LIMIT" value="8G"/>
        <const name="TESTS_MEM_LEAK_LIMIT" value=""/>
        <const name="TESTS_EXTRA_VERBOSE_LOG" value="1"/>
        <const name="TESTS_MAGENTO_MODE" value="developer"/>
        <const name="TESTS_ERROR_LOG_LISTENER_LEVEL" value="-1"/>
        <const name="USE_OVERRIDE_CONFIG" value="enabled"/>
    </php>
    <listeners>
        <listener class="Magento\TestFramework\Event\PhpUnit"/>
        <listener class="Magento\TestFramework\ErrorLog\Listener"/>
    </listeners>
</phpunit>
```

- To run integration tests, which require a Magento instance and a configured database, execute the following command:

```bash
vendor/bin/phpunit -c $(pwd)/dev/tests/integration/phpunit.xml app/code/Dnd/OffersBanner/Test/Integration/
```
