<?php namespace App\Http\Requests;

class RoleRequest extends Request {
    
        /**
         * The URI to redirect to if validation fails
         *
         * @var string
         */
        protected $redirect = 'acl/role';    

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'                  => 'required|unique:roles,name',
			'rights'                => 'required|boolean'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

}
