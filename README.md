# Laravel Package to generate Unique Identifiers

## Installation

Require this package

```
composer require continuum-digital/uid
```

## Usage

### Configuration

In your `database.config.php` file, create a new key to configure your uid's:
```
    'uid' => [
        'salt' => '', // Default ''
        'minLength' => '', // Default 0
        'alphabet' => '', // Default 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    ],
```
Remove the `salt`, `minLength` or `alphabet` to use default values.

### Database

Add the `$table->uid()` in your Schemas:

```
Schema::create('your_table', function (Blueprint $table) {
    $table->uid();
})
```

### Eloquent

Add the `HasUid` trait to your `Models` to add the capabilities:

* Local scope `$model->uid($uid)`
* Automatic generation of `uid` during the `creating` event

## Notes

This package use [HashIds](https://github.com/ivanakimov/hashids.php) under the hood.

