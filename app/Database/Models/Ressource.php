<?php namespace App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'ressources';

        /**
	 * @var array
	 */

	protected $fillable = [''];

        /**
	 * @var array
	 */

	protected $ressource = array();

        public $timestamps = false;


    /**
     * [role description]
     * @return [type] [description]
     * Ressources can have many Roles
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Database\Models\Role', 'roles_ressources');

    }

    /**
     * [role description]
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('\App\Database\Models\User', 'users_ressources');

    }

    /**
     * [findByName description]
     * @param  string $name [description]
     * @return [type]       [description]
     */
    public function findByName($name = 'lol')
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
     * @param  [type] $default_access [description]
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
     * @param  integer $id [description]
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
    public function getAll()
    {
        return $this->all();
    }
}
