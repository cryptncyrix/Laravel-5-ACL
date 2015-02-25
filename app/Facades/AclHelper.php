<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * AclHelper Facade
 */
class AclHelper extends Facade {

    /**
     * getFacadeAccessor
     * 
     * @return string
     */
    protected static function getFacadeAccessor() 
    { 
        return 'aclhelper';
    }
}
