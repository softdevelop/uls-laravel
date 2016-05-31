<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserModel;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Rowboat\Users\Models\UserModel as User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
protected $redirectPath = '/';
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout','autoLogin']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * auto login user
     *
     * @author Quang <quang@httsolution.com>
     * 
     * @param string $email user's auto login
     * 
     */
    public function autoLogin($email){
        if($email != 'stop') {
            $user = User::where('email',$email)->first();
            if($user){
                if(!\Session::has('old_user')) {
                    \Session::put('old_user', \Auth::user() != null ? \Auth::user()->email : 'stop');
                } else if(\Session::get('old_user') == $email){
                    //Stop being user
                    \Session::forget('old_user');
                }
                //login
                \Auth::login($user);

            }else{
                //if user not in system
                \Session::flash('auto-login', 'This account doesn\'t exist in the system');
            }
            return redirect('/');
        }    
    }

}
