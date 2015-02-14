<?php namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Database\Models\Resource;
use App\Http\Requests\ResourceRequest;
use App\Http\Requests\ResourceEditRequest;



/**
 * @Controller(prefix="acl")
 * @Middleware("acl")
 */

class ResourceController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Resource Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
    
       protected $resource;

       /**
	 * Create a new authentication controller instance.
	 *
	 * @param  Role  $resource
	 * @return void
	 */
	public function __construct(Resource $resource)
	{
            $this->resource = $resource;
            #$this->middleware('auth');
	}

	/**
	 * Show the application login form.
         * @GET("resource", as="acl.resource")
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getResource()
	{
		return view('resource.create');
	}

	/**
	 * Handle a login request to the application.
         * @POST("resource", as="acl.doResource")
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postPost(ResourceRequest $request)
	{
            $this->resource->insertNew($request->get('name'), $request->get('rights'));
            return redirect()->route('acl.resource')->with('msg', 
                                     'Resource erfolgreich angelegt.');
	}
        
        /**
	 * Show the application login form.
         * @GET("resource/edit/{name}", as="acl.editResource")
	 *
	 * @return \Illuminate\Http\Response
	 */
        public function getEditSingle($name)
        {
            $dbResource = $this->resource->findByName($name);
            return view('resource.editSingle', compact('dbResource')); 
        }

        /**
	 * Show the application login form.
         * @POST("resource/edit", as="acl.doEditResource")
	 *
	 * @return \Illuminate\Http\Response
	 */
        public function postEditSingle(ResourceEditRequest $request)
        {
            $this->resource->editById($request);
            return redirect()->route('acl.resource')->with('msg', 
                                     'Resource erfolgreich bearbeitet.');
        }
        
        /**
	 * Show the application login form.
         * @GET("resource/all", as="acl.allResources")
	 *
	 * @return \Illuminate\Http\Response
	 */
        public function getAll()
        {
            $dbResource = $this->resource->getAll(1);
            return view('resource.all', compact('dbResource'));
        }
}
