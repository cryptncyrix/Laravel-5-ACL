<?php namespace App\Database\Models;

use Hash;
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
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
        
        /**
         * [role description]
         * @return [type] [description]
         */
        public function resources()
        {
            return $this->belongsToMany('\App\Database\Models\Resource', 'users_resources');

        }
        
        /**
         * [role description]
         * @return [type] [description]
         * Ressources can have many Roles
         */
        public function roles()
        {
            return $this->belongsToMany('\App\Database\Models\Role', 'users_roles');

        }
        
        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */    
        public function getResourcesFromUserById($id = 0)
        {
            return $this->with('resources')->whereId($id)->get();
        }

        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */  
        public function setResourcesToUserById($id, $data)
        {
            return $this->find($id)->resources()->attach($data);
        }
        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */      
        public function removeResourcesFromUserById($id, $data)
        {
            return $this->find($id)->resources()->detach($data);
        }
        
        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */    
        public function getRolesFromUserById($id = 0)
        {
            return $this->with('roles')->whereId($id)->get();
        }

        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */  
        public function setRolesToUserById($id, $data)
        {
            return $this->find($id)->roles()->attach($data);
        }
        /**
         * [getResourcesFromRoleById description]
         * @return [type] [description]
         */      
        public function removeRolesFromUserById($id, $data)
        {
            return $this->find($id)->roles()->detach($data);
        }
        
        /**
         * [getAll description]
         * @return [type] [description]
         */
        public function getAll($limit = 5)
        {
            return $this->paginate($limit);
        }
        
}
