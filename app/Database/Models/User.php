<?php namespace App\Database\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    /**
     * [role description]
     * @return [type] [description]
     * Roles can have many Users
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Database\Models\Role', 'users_roles');

    }

    /**
     * [role description]
     * @return [type] [description]
     * Roles can have many Ressources
     */
    public function ressources()
    {
        return $this->belongsToMany('\App\Database\Models\Ressource', 'users_ressources');

    }

}
