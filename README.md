#### Access Control List for Laravel 5

> Give user individual rights and roles 

###### Install
-
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

## Todo
- Composer Install
- Command to Install Resources and Roles
