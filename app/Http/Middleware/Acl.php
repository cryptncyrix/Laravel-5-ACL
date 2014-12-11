<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

use App\Database\Models\Resource;

class Acl implements Middleware {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $resource;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
  	public function __construct(Guard $auth, Resource $resource)
	 {
 		$this->auth     = $auth;
                $this->resource = $resource;
  	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
        public function handle($request, Closure $next)
	{
	    if ( ! $this->auth->guest() )
	    {

                $objectUser = $this->auth->user();
                $objectUser->load('roles', 'roles.resources', 'resources');
    
                if( $this->getUserAccess($objectUser->resources,  $request->route()->getName())   )
                {
                    return $next($request);

                } else if( $this->getRoleAccess($objectUser->roles,  $request->route()->getName() ) )
                {
                    return $next($request);

                } else if( $this->getDefaultAccess( $request->route()->getName() ) )
                {
                    return $next($request); 
                }
	    }	
            return ($request->ajax()) ? response('Unauthorized.', 401) : redirect()->guest('auth/login');    
	}

	/**
	 * Get the default access for this resource
	 *
	 * @param  $stringName
	 * @return bool
	 */

        protected function getDefaultAccess($stringName) 
        {
            return $this->resource->getAccessByname($stringName)->default_access;
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
