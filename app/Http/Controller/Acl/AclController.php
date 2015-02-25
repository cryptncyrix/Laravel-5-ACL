<?php namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Database\Models\Resource;
use App\Database\Models\Role;
use App\Database\Models\User;
use App\Http\Requests\RoleResourcesRequest;
use App\Http\Requests\UserResourcesRequest;



/**
 * @Controller(prefix="acl")
 * @Middleware("acl")
 */

class AclController extends Controller {
    
    /*
    |--------------------------------------------------------------------------
    | Acl Controller
    |--------------------------------------------------------------------------
    */

    /**
     * @var type 
     */
    
    protected $resource;
    
    /**
     * @var type 
     */
    protected $role;  
    
    /**
     * @var type 
     */
    protected $user; 

   /**
     * Create a new authentication controller instance.
     *
     * @param  Role  $role
     * @param  Resource  $resource
     * @return void
     */
    public function __construct(Resource $resource, Role $role, User $user)
    {
        $this->resource = $resource;
        $this->role     = $role;
        $this->user     = $user;
    }

   /**
     * Create a new authentication controller instance.
     * @GET("role/resource/{id}", as="acl.listRoleResources")
     * 
     * @param  integer  $id
     * @return void
     */        
    public function getRoleResources($id)
    {

        $dbResource = $this->resource->getAllWithoutPaginate()->toArray();
        $dbRole     = $this->role->getResourcesFromRoleById($id)->toArray();
        $elements   = ($dbRole != [] ) ? $this->getElements($dbRole[0]['resources'] , $dbResource) : false;

        if($elements == false)
        {
            return redirect()->route('acl.resource')->with('msg', 
                                 'Bitte erst eine Resource anlegen.');
        }

        return view('acl.getRoleResource', compact('elements', 'id'));
    }

    /**
     * Create a new authentication controller instance.
     * @POST("role/resource", as="acl.doListRoleResources")
     * 
     * @return void
     */

    public function postRoleResources(RoleResourcesRequest $request)
    {
        $input = $this->getChangedElements($request);

        $this->setAndRemoveById($request->get('_id'), $input, 'Role.Resources');        
        return redirect()->route('acl.listRoleResources', $request->get('_id'))->with('msg', 'Die Rechte wurden für die Rolle angepasst.');
    }



    /**
     * Create a new authentication controller instance.
     * @GET("user/resource/{id}", as="acl.listUserResources")
     * 
     * @param  integer  $id
     * @return void
     */        
    public function getUserResources($id)
    {
        $dbResource = $this->resource->getAllWithoutPaginate()->toArray();
        $dbUser     = $this->user->getResourcesFromUserById($id)->toArray();           
        $elements   = ($dbUser != [] ) ? $this->getElements($dbUser[0]['resources'] , $dbResource) : false;

        if($elements == false)
        {
            return redirect()->route('acl.resource')->with('msg', 
                                 'Bitte erst eine Resource anlegen.');
        }
        return view('acl.getUserResource', compact('elements', 'id'));
    }

   /**
     * Create a new authentication controller instance.
     * @POST("user/resource", as="acl.doListUserResources")
     * 
     * @return void
     */

    public function postUserResources(UserResourcesRequest $request)
    {
        $input = $this->getChangedElements($request);
        $this->setAndRemoveById($request->get('_id'), $input, 'User.Resources');      
        return redirect()->route('acl.listUserResources', $request->get('_id'))->with('msg', 'Die Rechte wurden für den User angepasst.');
    }

   /**
     * Create a new authentication controller instance.
     * @GET("user/role/{id}", as="acl.listUserRoles")
     * 
     * @param  integer  $id
     * @return void
     */        
    public function getUserRoles($id)
    {
        $dbRole     = $this->role->getAllWithoutPaginate()->toArray();
        $dbUser     = $this->user->getRolesFromUserById($id)->toArray();
        $elements   = ($dbUser != [] ) ? $this->getElements($dbUser[0]['roles'] , $dbRole) : false;

        if($elements == false)
        {
            return redirect()->route('acl.role')->with('msg', 
                                 'Bitte erst eine Rolle anlegen.');
        } 
        return view('acl.getUserRole', compact('elements', 'id'));
    }

   /**
     * Create a new authentication controller instance.
     * @POST("user/role", as="acl.doListUserRoles")
     * 
     * @return void
     */

    public function postUserRoles(UserResourcesRequest $request)
    {
        $input = $this->getChangedElements($request);
        $this->setAndRemoveById($request->get('_id'), $input, 'User.Roles'); 
        return redirect()->route('acl.listUserRoles', $request->get('_id'))->with('msg', 'Die Rollen wurden für den User angepasst.');
    }

   /**
     * Create a new authentication controller instance.
     * @GET("overview", as="acl.overview")
     * 
     * @param  integer  $id
     * @return void
     */        
    public function getOverview()
    {
        return view('acl.getOverview');
    }

    /**
     * Get all Elements from Database
     * @param array $dbAll
     * @param array $dbFromId
     * @return boolean
     */

    protected function getElements(array $dbAll, array $dbFromId)
    {
        $elements = [];
        if($dbAll == [] && $dbFromId == [])
        {
            return false;
        } 
        else if($dbAll == [])
        {
            foreach($dbFromId as $dbValue)
            {
                $elements[$dbValue['id']] = [0 => false, 1 => $dbValue['name']];
            }                
        }
        else
        {
            foreach($dbFromId as $dbValue)
            {
                foreach($dbAll as $value)
                {

                    if($dbValue['id'] == $value['id'])
                    {
                        $elements[$dbValue['id']] = [0 => true, 1 => $dbValue['name']];
                        break;
                    }

                    $elements[$dbValue['id']] = [0 => false, 1 => $dbValue['name']];
                }
            }                
        }
        return $elements;
    }
    /**
     * Get all Changed Elements from Request
     * @param Request $request
     * @return array
     */
    protected function getChangedElements($request)
    {
        $delete = $add = [];
        $input  = $request->except('_token', '_id');  

        foreach($input as $key => $value)
        {
            if(!is_int($key))
            {
                continue;
            }

            if($value == true)
            {
                if($input['old_' . $key] == 0)
                {
                    $add[] = $key;
                }
                continue;
            }
            else
            {
                $delete[] = $key;
            }
        }  
        return ['add' => $add, 'delete' => $delete];
    }    

    /**
     * Set and Remove the Input to the Database from the Form
     * @param integer $id
     * @param array $input
     * @param string $function
     * @return boolean
     */
    protected function setAndRemoveById($id, $input, $function)
    {
        $setString    = 'set' . substr(strstr($function, '.'),1 ) . 'To' . 
                       strstr($function, '.', true) . 'ById';

        $removeString = 'remove' . substr(strstr($function, '.'),1 ) . 'From' . 
                       strstr($function, '.', true) . 'ById';

        if($input['add'] != [])
        {
            $this->{strtolower(strstr($function, '.', true))}->{$setString}($id, $input['add']);
        }
        if($input['delete'] != [])
        {
            $this->{strtolower(strstr($function, '.', true))}->{$removeString}($id, $input['delete']);
        }
        return true;
    }
}
