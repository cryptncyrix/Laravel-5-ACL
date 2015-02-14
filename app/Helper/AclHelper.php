<?php namespace App\Helper;

use App\Database\Models\Resource;
use Illuminate\Contracts\Auth\Guard;

class AclHelper {
    
    /**
     * auth
     * @var object 
     */
    protected $auth;
    
    /**
     * user
     * @var object 
     */
    protected $user;


    /**
     * 
     * @param Guard $auth
     * @param Resource $resource
     */
    public function __construct(Guard $auth, Resource $resource) 
    {
        $this->auth     = $auth;
        $this->resource = $resource;
        $this->getAllUserPermissions();
    }

    /**
     * Get all User Auth Data
     * @return \App\Helper\AclHelper
     */
    
    public function getAllUserPermissions()
    {
        
        if(!$this->auth->guest())
        {
            $this->user = $this->auth->user();
            $this->user->load('roles', 'roles.resources', 'resources');   
            return $this;
        }
        
    }
    
    /**
     * Check the Resource of Rights
     * @param string $toCheckedString
     * @return boolean
     */  
    
    public function checkUserPermissions($toCheckedString, $defaultAccess = null)
    {   
        if(!$this->auth->guest())
        {
            if( $this->getUserAccess($this->user->resources,  $toCheckedString)   )
            {
                return true;

            } else if( $this->getRoleAccess($this->user->roles,  $toCheckedString ) )
            {
                return true;

            } else if( $this->getDefaultAccessFromResource($toCheckedString, $defaultAccess ) )
            {
                return true;
            } 
        }
        return false;
    }
    
    /**
     * Get all true Resources 
     *
     * @return array
     */    
    public function getAllTrueResources()
    {
        $array = [];
        foreach($this->resource->getAllWithoutPaginate() as $value)
        {
            if($this->checkUserPermissions($value['name'], $value['default_access']))
            {
                $array[] = $value['name'];
            }
        }
        return $array;
    }
    
    /**
     * Get the default access for this resource
     *
     * @param  $stringName
     * @return bool
     */

    protected function getDefaultAccessFromResource($stringName, $defaultAccess) 
    {
        if(is_null($defaultAccess))
        {
            return $this->resource->getAccessByname($stringName)->default_access;
        }
        return ($defaultAccess == true) ? true : false;
    }
    
    /**
     * Check - is the ressource set ;)
     *
     * @param  $objectResources
     * @param  $stringResource
     * @return bool
     */

    protected function getUserAccess($objectResources, $stringResource)
    {
        foreach($objectResources as $value) {

             if($value->name == $stringResource){
                 return true;
             }
        }  
        return false;          
    }

    /**
     * Check - has the Role the Resource ;)
     *
     * @param  $objectRole
     * @param  $stringResource
     * @return bool
     */

    protected function getRoleAccess($objectRole, $stringResource)
    {

        foreach($objectRole as $value) {

            if($value->default_access == true) 
            {
                return true;

            } else {

                return $this->getUserAccess($value->resources, $stringResource);
            }
        }
        return false;            
    } 
}


