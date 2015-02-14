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
	 * @var array
	 */

	protected $fillable = ['name', 'default_access'];

        /**
	 * @var array
	 */

	protected $role = array();


    /**
     * [role description]
     * @return [type] [description]
     * Ressources can have many Roles
     */
        public function resources()
    {
        return $this->belongsToMany('\App\Database\Models\Resource', 'roles_resources');

    }

    /**
     * [role description]
     * @return [type] [description]
     * Ressources can have many Roles
     */
    public function users()
    {
        return $this->belongsToMany('\App\Database\Models\User', 'users_roles');

    }
    /**
     * [findByName description]
     * @param  string $name [description]
     * @return [type]       [description]
     */
    public function findByName($name = 'foF')
    {
        return $this->whereName($name)->firstOrFail();
    }

    /**
     * [getNameById description]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function getNameById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('name'));
    }
    
    /**
     * [insertNew description]
     * @param  [type] $name           [description]
     * @param  [type] $bool           [description]
     * @return [type]                 [description]
     */
    public function editById($data)
    {
        $role                 = $this->find($data->get('_id'));
        $role->name           = $data->get('name');
        $role->default_access = $data->get('rights');
        return $role->save();
    }
    
    /**
     * [insertNew description]
     * @param  [type] $name           [description]
     * @param  [type] $bool [description]
     * @return [type]                 [description]
     */
    public function insertNew($name, $bool = NULL)
    {
        $this->name           = $name;
        $this->default_access = $bool;
        return $this->save();
    }

    /**
     * [getAccessById description]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function getAccessById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('access'));   
    }
    
    /**
     * [getAll description]
     * @return [type] [description]
     */
    public function getAll($limit = 5)
    {
        return $this->paginate($limit);
    }
    
    /**
     * [getAll description]
     * @return [type] [description]
     */    
    public function getAllWithoutPaginate()
    {
        return $this->all();
    }
    
    /**
     * [getResourcesFromRoleById description]
     * @return [type] [description]
     */    
    public function getResourcesFromRoleById($id = 0)
    {
        return $this->with('resources')->whereId($id)->get();
    }
    
    /**
     * [getResourcesFromRoleById description]
     * @return [type] [description]
     */  
    public function setResourcesToRoleById($id, $data)
    {
        return $this->find($id)->resources()->attach($data);
    }
    /**
     * [getResourcesFromRoleById description]
     * @return [type] [description]
     */      
    public function removeResourcesFromRoleById($id, $data)
    {
        return $this->find($id)->resources()->detach($data);
    }
}
