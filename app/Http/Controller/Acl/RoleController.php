<?php namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Database\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleEditRequest;


/**
 * @Controller(prefix="acl")
 * @Middleware("acl")
 */

class RoleController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Acl Controller
    |--------------------------------------------------------------------------
    */
    
    /**
     *
     * @var type 
     */
    
    protected $role;

    /**
      * Create a new authentication controller instance.
      *
      * @param  Role  $role
      * @return void
      */
     public function __construct(Role $role)
     {
         $this->role = $role;
     }

     /**
      * Show the application login form.
      * @GET("role", as="acl.role")
      *
      * @return \Illuminate\Http\Response
      */
     public function getRoles()
     {
        return view('role.create');
     }

     /**
      * Handle a login request to the application.
      * @POST("role", as="acl.doRole")
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function postRoles(RoleRequest $request)
     {
         $this->role->insertNew($request->get('name'), $request->get('rights'));
         return redirect()->route('acl.role')->with('msg', 
                                  'Rolle erfolgreich angelegt.');
     }

     /**
      * Show the application login form.
      * @GET("role/edit/{name}", as="acl.editRole")
      *
      * @return \Illuminate\Http\Response
      */
     public function getEditSingle($name)
     {
         $dbRole = $this->role->findByName($name);
         return view('role.editSingle', compact('dbRole')); 
     }

     /**
      * Show the application login form.
      * @POST("role/edit", as="acl.doEditRole")
      *
      * @return \Illuminate\Http\Response
      */
     public function postEditSingle(RoleEditRequest $request)
     {
         $this->role->editById($request);
         return redirect()->route('acl.role')->with('msg', 
                                  'Rolle erfolgreich bearbeitet.');
     }

     /**
      * Show the application login form.
      * @GET("role/all", as="acl.allRoles")
      *
      * @return \Illuminate\Http\Response
      */
     public function getAll()
     {
         $dbRole = $this->role->getAll(1);
         return view('role.all', compact('dbRole'));
     }

}
