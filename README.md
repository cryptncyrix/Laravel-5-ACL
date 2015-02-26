Laravel-5-ACL
=============

Access Control List

Install
-

Edit config/app and add

```php
//My Provider
'App\Providers\AclServiceProvider',
```

and
```php
//My Facade
'AclHelper'     => 'App\Facades\AclHelper',
```
