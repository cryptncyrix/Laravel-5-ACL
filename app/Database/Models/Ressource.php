<?php namespace App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'resources';

        /**
	 * @var array
	 */

	protected $fillable = ['name', 'default_access'];

        /**
         * No Timestamps
	 * @var bool
	 */
        public $timestamps = false;


    /**
     * [role description]
     * @return [type] [description]
     * Ressources can have many Roles
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Database\Models\Role', 'roles_resources');

    }

    /**
     * [role description]
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('\App\Database\Models\User', 'users_resources');

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
        $resource                 = $this->find($data->get('_id'));
        $resource->name           = $data->get('name');
        $resource->default_access = $data->get('rights');
        return $resource->save();
    }
    
    /**
     * [insertNew description]
     * @param  [type] $name           [description]
     * @param  [type] $bool           [description]
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
        return $this->whereId($id)->firstOrFail(array('default_access'));   
    }

    /**
     * [getAccessByname description]
     * @param  integer $name [description]
     * @return [type]      [description]
     */
    public function getAccessByname($name = '')
    {
        return $this->whereName($name)->firstOrFail(array('default_access'));   
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
}
