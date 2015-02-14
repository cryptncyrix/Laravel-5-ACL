<?php namespace App\Http\Requests;

class ResourceRequest extends Request {
    
        /**
         * The URI to redirect to if validation fails
         *
         * @var string
         */
        protected $redirect = 'acl/resource';    

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'                  => 'required||max:200|unique:resources,name',
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
