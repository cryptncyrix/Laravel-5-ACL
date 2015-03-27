<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Database\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;

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
    public function getAll(Request $httpRequest)
    {
        setSessionBackLink($httpRequest->route()->getName());
        $dbUser = $this->user->getAll(25)->setPath(route('user.all'));
        return view('user.all', compact('dbUser'));
    }
    
    /**
     * Show the User Create Form
     * @GET("/create", as="user.create")
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('user.create');
    }
    /**
     * Set the new User
     * @POST("/create", as="user.doCreate")
     * @param UserCreateRequest $request
     * @return type
     */    
    public function postCreate(UserCreateRequest $request)
    {
        if($this->user->insertNewUser($request) == true) 
        {   
            return redirect()->route('user.create')->with('msg', 'User wurde erfolgreich angelegt.');
        }  
        
        return redirect()->route('user.create')->with('msg', 'Fehlerhafte Eingaben, User konnte nicht angelegt werden.');
    }
    
    
    /**
     * Show the User Create Form
     * @GET("/edit/{id}", as="user.edit")
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit(User $user, $id)
    {
        $dbUser = $user->find($id);
        return view('user.edit', compact('dbUser'));
    }
    
    /**
     * Show the application login form.
     * @POST("/edit/{id}", as="user.doEdit")
     * @Middleware("acl")
     * @return \Illuminate\Http\Response
     */
    public function postEdit(UserEditRequest $request, User $user)
    {    
        if($user->editDataById($request->except('_token', 'password_confirmation'), $request->route('id')) == true)
        {
            return redirect()->route(getSessionBackLink('user.edit'))->with('msg', 'User wurde erfolgreich geändert');
        }
        return redirect()->route(getSessionBackLink('user.edit'))->with('msg', 'User konnte nicht geändert werden');
    }

}
