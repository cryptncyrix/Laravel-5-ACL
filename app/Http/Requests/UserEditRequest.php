<?php namespace App\Http\Requests;
use App\Database\Models\User;

class UserEditRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'unique:users,name',
            'email'                 => 'email|unique:users,email',
            'password'              => 'max:200',
            'password_confirmation' => 'same:password'
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
