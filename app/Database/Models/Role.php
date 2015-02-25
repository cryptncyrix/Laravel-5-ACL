<?php namespace App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'default_access'];
    
    /**
     * Set Timestamps
     * 
     * @var type 
     */
    public $timestamps = false;


    /**
     * @param void
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function resources()
    {
        return $this->belongsToMany('\App\Database\Models\Resource', 'roles_resources');

    }

    /**
     * @param void
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('\App\Database\Models\User', 'users_roles');

    }
    /**
     * Find the role by Name
     * @param  string $name | default admin
     * @return object
     */
    public function findByName($name = 'admin')
    {
        return $this->whereName($name)->firstOrFail();
    }

    /**
     * Get the role Name by Id
     * @param  integer $id | default 0
     * @return object
     */
    public function getNameById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('name'));
    }
    
    /**
     * Edit the role by Id
     * @param  object $data
     * @return bool
     */
    public function editById($data)
    {
        $role                 = $this->find($data->get('_id'));
        $role->name           = $data->get('name');
        $role->default_access = $data->get('rights');
        return $role->save();
    }
    
    /**
     * Insert a new One
     * @param string $name
     * @param bool $bool | default NULL - DefaultAccess for Resource
     * @return bool
     */
    public function insertNew($name, $bool = NULL)
    {
        $this->name           = $name;
        $this->default_access = $bool;
        return $this->save();
    }

    /**
     * Get the access from resource by Id
     * @param  integer $id | default 0
     * @return bool
     */
    public function getAccessById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('default_access'));   
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
    
    /**
     * Get all Roles without Paginate
     * @return object
     */    
    public function getAllWithoutPaginate()
    {
        return $this->all();
    }
    
    /**
     * Get all resources from role by id
     * @param integer $id | default 0
     * @return object
     */    
    public function getResourcesFromRoleById($id = 0)
    {
        return $this->with('resources')->whereId($id)->get();
    }
    
    /**
     * Set the Resource to Role
     * @param integer $id 
     * @param object $data
     * @return object
     */   
    public function setResourcesToRoleById($id, $data)
    {
        return $this->find($id)->resources()->attach($data);
    }
    /**
     * Remove the Resource from Role
     * @param integer $id 
     * @param object $data
     * @return object
     */       
    public function removeResourcesFromRoleById($id, $data)
    {
        return $this->find($id)->resources()->detach($data);
    }
}
