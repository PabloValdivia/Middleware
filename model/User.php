<?php 

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
| This class handles all methods for Users model
|
*/
class User
{
    /*
    |--------------------------------------------------------------------------
    | Data User
    |--------------------------------------------------------------------------
    |
    | Define the data of the current user
    |
    */
    /** User First name */
    public $f_name = '';

    /** User Last name */
    public $l_name = '';

    /** User Email */
    public $email = '';

    /** User ID */
    public $id = null;

    /** User Password */
    public $pass = null;

    /** Model */
    public $model = 'user';

    /** Controller */
    public $controller = 'login';

    public function __construct($id)
    {
        $this->id = $id;
    }

}
