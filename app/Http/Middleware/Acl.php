<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

use App\Database\Models\Ressource;

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
	protected $ressource;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
  	public function __construct(Guard $auth, Ressource $ressource)
	 {
 		$this->auth      = $auth;
                $this->ressource = $ressource;
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
                $objectUser->load('roles', 'roles.ressources', 'ressources');
    
                if( $this->getUserAccess($objectUser->ressources,  $request->route()->getName())   )
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
	 * Get the default access for this ressource
	 *
	 * @param  $stringName
	 * @return bool
	 */

        protected function getDefaultAccess($stringName) 
        {
            return $this->ressource->getAccessByname($stringName)->default_access;
        }

	/**
	 * Check - is the ressource set ;)
	 *
	 * @param  $objectRessources
	 * @param  $stringRessource
	 * @return bool
	 */

        protected function getUserAccess($objectRessources, $stringRessource)
        {
            foreach($objectRessources as $value) {

                 if($value->name == $stringRessource){
                     return true;
                 }
            }  
            return false;          
        }

	/**
	 * Check - has the Role the Ressource ;)
	 *
	 * @param  $objectRole
	 * @param  $stringRessource
	 * @return bool
	 */

        protected function getRoleAccess($objectRole, $stringRessource)
        {

            foreach($objectRole as $value) {

                if($value->default_access == true) 
                {
                    return true;

                } else {

                    return $this->getUserAccess($value->ressources, $stringRessource);
                }
            }
            return false;            
        }
}
