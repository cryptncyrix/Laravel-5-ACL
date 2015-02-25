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
    public function roles()
    {
        return $this->belongsToMany('\App\Database\Models\Role', 'roles_resources');

    }

    /**
     * @param void
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('\App\Database\Models\User', 'users_resources');

    }

    /**
     * Find the resource by Name
     * @param  string $name | default home
     * @return object
     */
    public function findByName($name = 'home')
    {
        return $this->whereName($name)->first();
    }

    /**
     * Get the resource Name by Id
     * @param  integer $id | default 0
     * @return object
     */
    public function getNameById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('name'));
    }
    
    /**
     * Edit the resource by Id
     * @param  object $data
     * @return bool
     */
    public function editById($data)
    {
        $resource                 = $this->find($data->get('_id'));
        $resource->name           = $data->get('name');
        $resource->default_access = $data->get('rights');
        return $resource->save();
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
     * Set all Routes as Resource
     * @param object $routes
     * @return \App\Database\Models\Resource
     */
    public function setAllNewRoutesToResources($routes)
    {
        foreach($routes as $value)
        {
            if(is_null($value->getName()))
            {
                continue;
            }

           $this->firstOrCreate(['name' => $value->getName()]);
        }   
        
        return $this;
    }

    /**
     * Get the default_access from resource by Id
     * @param  integer $id | default 0
     * @return bool
     */
    public function getAccessById($id = 0)
    {
        return $this->whereId($id)->firstOrFail(array('default_access'));   
    }

    /**
     * Get the default_access from resource by Name
     * @param  string $name | default emptystring
     * @return bool
     */
    public function getAccessByname($name = '')
    {
        return $this->whereName($name)->firstOrFail(array('default_access'));   
    }
    
    /**
     * Get all Resource with Paginate
     * @param  integer $limit | default 25
     * @return object
     */
    
    public function getAll($limit = 25)
    {
        return $this->paginate($limit);
    }
    
    /**
     * Get all Resource without Paginate
     * @return object
     */    
    public function getAllWithoutPaginate()
    {
        return $this->all();
    }
}
