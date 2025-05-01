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


## Extensibility

Extension developers can interact with the Dnd_OffersBanner module. For more information about the Magento extension mechanism, see [Magento plug-ins](https://developer.adobe.com/commerce/php/development/components/plugins/).

[The Magento dependency injection mechanism](https://developer.adobe.com/commerce/php/development/build/dependency-injection-file/) enables you to override the functionality of the Dnd_OffersBanner module.


## Testing the OffersBanner Module

This module includes PHPUnit-based **unit tests**

---

### 1. Run Unit Tests

```bash
vendor/bin/phpunit -c app/code/Dnd/OffersBanner/phpunit.xml app/code/Dnd/OffersBanner/Test/Unit/
```
