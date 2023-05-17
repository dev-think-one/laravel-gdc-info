# GDC Info checker

GDC info parser

## Installation

Install the package via composer:

```shell
composer require yaroslawww/laravel-gdc-info
```

Optionally you can publish the config file with:

```shell
php artisan vendor:publish --provider="GDCInfo\ServiceProvider" --tag="config"
```

## Installation

1. Create settings table

```php
public function up() {
    Schema::create( config('gdc-info.tables.gdc_info'), function ( Blueprint $table ) {
        \GDCInfo\MigrationHelper::defaultColumns($table);
    } );
}
```

2. Set your model in AppServiceProvider if you need

```php
namespace App\Models;

class GDCInfo extends \GDCInfo\Models\GDCInfo
{
}
```

```php
public function register()
{
    GDCChecker::useModel(\App\Models\GDCInfo::class);
}
```

## Usage

Direct call (you can use it without model and table):

```php
$gdcInfo = GDCInfoFromHtmlFlow::make()->get('060702');
// or
$gdcInfo = GDCInfoFromHtmlFlow::make()->get(60702);

$gdcInfo->gdc();
$gdcInfo->firstName();
$gdcInfo->lastName();
$gdcInfo->status();
$gdcInfo->registrantType();
$gdcInfo->qualifications();
$gdcInfo->firstRegisteredOn();
$gdcInfo->currentPeriodFrom();
$gdcInfo->additionalInfo();
```

Using Model:
```php
$gdcInfo = GDCInfo::findOrFetch(60702);

$gdcInfo->getKey();
$gdcInfo->last_name;
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/) 
