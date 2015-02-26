#### Access Control List for Laravel 5

> Give user individual rights and roles

###### Install

> Edit config/app and add the following lines

```php
  'providers' => [
    // ...
    'App\Providers\AclServiceProvider',
    // ...
  ];
```

```php
  'aliases' => [
    // ...
    'AclHelper'     => 'App\Facades\AclHelper',
    // ...
  ];
```

###### Usage

> Controller Example Class and Method

```php
/**
 * @Middleware("acl")
 */
```

> Blade Example

```php
@if(hasResource('acl.listUserResources'))
    <a href="{!! route('acl.listUserResources', 1) !!}">User Rechte hinzufügen </a>
@endif
```

###### Requirements

- <a href="http://laravel.com/docs/5.0">Laravel 5</a>
- <a href="https://github.com/LaravelCollective/annotations">LaravelCollective/annotations</a>
- <a href="https://github.com/LaravelCollective/html">Laravel Form and Html Package</a>

## Todo
- [ ] Composer Install
- [ ] Command to Install Resources and Roles
