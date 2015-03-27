<?php namespace App\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;

class User extends Model {

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
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
        
    /**
     * @param void
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function resources()
    {
        return $this->belongsToMany('\App\Database\Models\Resource', 'users_resources');

    }
        
    /**
     * @param void
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Database\Models\Role', 'users_roles');

    }
    
    /**
     * @param $data
     *
     * @return bool
     */
    public function insertNewUser($data)
    {
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = $data->password;

        return $this->save();

    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function setNewPassword($data, $id)
    {
        $user = User::find($id);
        $user->password = $data['password'];

        return $user->save();

    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function editDataById($data, $id)
    {
        $user = User::find($id);
        
        foreach($data as $key => $value)
        {
            if(!empty($value))
            {
                $user->{$key} = $value;
            }
        }

        return $user->save();
    }
        
    /**
     * Get all resources from user by id
     * @param integer $id | default 0
     * @return object
     */     
    public function getResourcesFromUserById($id = 0)
    {
        return $this->with('resources')->whereId($id)->get();
    }

    /**
     * Set the Resource to User
     * @param integer $id 
     * @param object $data
     * @return object
     */  
    public function setResourcesToUserById($id, $data)
    {
        return $this->find($id)->resources()->attach($data);
    }
    
    /**
     * Remove the Resource from User
     * @param integer $id 
     * @param object $data
     * @return object
     */     
    public function removeResourcesFromUserById($id, $data)
    {
        return $this->find($id)->resources()->detach($data);
    }
        
    /**
     * Get all Roles from user by id
     * @param integer $id | default 0
     * @return object
     */   
    public function getRolesFromUserById($id = 0)
    {
        return $this->with('roles')->whereId($id)->get();
    }

    /**
     * Set the Roles to User
     * @param integer $id 
     * @param object $data
     * @return object
     */
    public function setRolesToUserById($id, $data)
    {
        return $this->find($id)->roles()->attach($data);
    }
        
    /**
     * Remove the Roles from User
     * @param integer $id 
     * @param object $data
     * @return object
     */       
    public function removeRolesFromUserById($id, $data)
    {
        return $this->find($id)->roles()->detach($data);
    }
        
    /**
     * Get all Roles with Paginate
     * @param  integer $limit | default 25
     * @return object
     */
    public function getAll($limit = 25)
    {
        return $this->paginate($limit);
    }
        
}
