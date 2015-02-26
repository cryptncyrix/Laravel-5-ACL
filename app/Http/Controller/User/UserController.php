<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Database\Models\User;
/**
 * @Controller(prefix="user")
 * @Middleware("acl")
 */

class UserController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    */
    
    /**
     *
     * @var type 
     */
    protected $user;

    /**
     * Create a new authentication controller instance.
     *
     * @param  User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Show the application login form.
     * @GET("all", as="user.all")
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $dbUser = $this->user->getAll(25);
        return view('user.all', compact('dbUser'));
    }

}
