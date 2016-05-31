<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\UserModel as User;

class CreateUserTest extends TestCase
{
    public function testLoginUserAdmin()
    {
        $this->post('auth/login', ['email' => 'admin@rowboatllc.com', 'password' => 'admin']);
        if (\Auth::user()) {
            echo 'Login successfull!';
        } else {
            echo 'Login Faild!';
        }

    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateNewUserWithEmtypeFirstName()
    {
        $dataUser = [
            'first_name' => '',
            'last_name' => 'Tuan',
            'email' => 'tuan@httsolution.com'
        ];

        $this->post('api/user', $dataUser);
        $dataResult = $this->getContents();

        dd($dataResult);
    }
}
