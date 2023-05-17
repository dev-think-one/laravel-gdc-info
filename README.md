# GDC Info checker

GDC info parser

## Installation

Install the package via composer:

```shell
composer require yaroslawww/laravel-gdc-info
```

Optionally you can publish the config file with:

```shell
php artisan vendor:publish --provider="FMCAdManager\ServiceProvider" --tag="config"
```

## Installation

1. Create settings table

```injectablephp
public function up() {
    Schema::create( config('gdc-info.tables.gdc_info'), function ( Blueprint $table ) {
        \GDCInfo\MigrationHelper::defaultColumns($table);
    } );
}
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/) 
