<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

use App\Database\Models\Resource;
use App\Helper\AclHelper;

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
            $this->aclHelper = new AclHelper($auth, $resource);
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
	    if ( $this->aclHelper->checkUserPermissions($request->route()->getName()) )
	    {
                return $next($request);
            }
            return ($request->ajax()) ? response('Unauthorized.', 401) : redirect()->guest('auth/login');    
	}

}
