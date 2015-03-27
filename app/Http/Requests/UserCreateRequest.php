<?php namespace App\Http\Requests;

class UserCreateRequest extends Request {

    /**
     * The URI to redirect to if validation fails
     *
     * @var string
     */
    protected $redirect = 'user/create';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|min:6|unique:users,name',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8',
            'password_confirmation‏' => 'same:password'
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
