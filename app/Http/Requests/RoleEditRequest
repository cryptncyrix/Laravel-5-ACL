<?php namespace App\Http\Requests;

class RoleEditRequest extends Request {
    
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
                        '_id'                   => 'required|integer',
			'name'                  => 'required|max:200',
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
