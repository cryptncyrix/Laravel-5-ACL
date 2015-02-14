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
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
    
       protected $resource;
       protected $role;  
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
            #$this->middleware('acl');
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
            $elements = [];
            $dbResource = $this->resource->getAllWithoutPaginate()->toArray();
            $dbRole     = $this->role->getResourcesFromRoleById($id)->toArray();

            if($dbRole == [] || ( $dbRole[0]['resources'] == [] && $dbResource == [] ))
            {
                return redirect()->route('acl.resource')->with('msg', 
                                     'Bitte erst eine Resource anlegen.');
            } 
            else if($dbRole[0]['resources'] == [])
            {
                foreach($dbResource as $dbValue)
                {
                    $elements[$dbValue['id']] = [0 => false, 1 => $dbValue['name']];
                }                
            }
            else
            {
                foreach($dbResource as $dbValue)
                {
                    foreach($dbRole[0]['resources'] as $value)
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
            
            if($add != [])
            {
                $this->role->setResourceToRoleById($request->get('_id'), $add);
            }
            if($delete != [])
            {
                $this->role->removeResourceFromRoleById($request->get('_id'), $delete);
            }            
            return redirect()->route('acl.listRoleResources', $request->get('_id'))->with('msg', 'Die Rechte wurden fÃ¼r die Rolle angepasst.');
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
            $elements = [];
            $dbResource = $this->resource->getAllWithoutPaginate()->toArray();
            $dbUser     = $this->user->getResourcesFromUserById($id)->toArray();

            if($dbUser == [] || ( $dbUser[0]['resources'] == [] && $dbResource == [] ))
            {
                return redirect()->route('acl.resource')->with('msg', 
                                     'Bitte erst eine Resource anlegen.');
            } 
            else if($dbUser[0]['resources'] == [])
            {
                foreach($dbResource as $dbValue)
                {
                    $elements[$dbValue['id']] = [0 => false, 1 => $dbValue['name']];
                }                
            }
            else
            {
                foreach($dbResource as $dbValue)
                {
                    foreach($dbUser[0]['resources'] as $value)
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
            
            if($add != [])
            {
                $this->user->setResourceToUserById($request->get('_id'), $add);
            }
            if($delete != [])
            {
                $this->user->removeResourceFromUserById($request->get('_id'), $delete);
            }            
            return redirect()->route('acl.listUserResources', $request->get('_id'))->with('msg', 'Die Rechte wurden fÃ¼r den User angepasst.');
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
            $elements = [];
            $dbRole     = $this->role->getAllWithoutPaginate()->toArray();
            $dbUser     = $this->user->getRolesFromUserById($id)->toArray();

            if($dbUser == [] || ( $dbUser[0]['roles'] == [] && $dbRole == [] ))
            {
                return redirect()->route('acl.role')->with('msg', 
                                     'Bitte erst eine Rolle anlegen.');
            } 
            else if($dbUser[0]['roles'] == [])
            {
                foreach($dbRole as $dbValue)
                {
                    $elements[$dbValue['id']] = [0 => false, 1 => $dbValue['name']];
                }                
            }
            else
            {
                foreach($dbRole as $dbValue)
                {
                    foreach($dbUser[0]['roles'] as $value)
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
            
            if($add != [])
            {
                $this->user->setRoleToUserById($request->get('_id'), $add);
            }
            if($delete != [])
            {
                $this->user->removeRoleFromUserById($request->get('_id'), $delete);
            }            
            return redirect()->route('acl.listUserRoles', $request->get('_id'))->with('msg', 'Die Rollen wurden fÃ¼r den User angepasst.');
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
}
