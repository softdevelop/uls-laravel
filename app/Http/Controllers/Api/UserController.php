<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\UserModel as User;
use Rowboat\Users\Http\Requests\UserFormRequest;
use Rowboat\Users\Models\PersonalInformationModel;
use App\Services\TimeService;
use Rowboat\Users\Services\MailService;
use Rowboat\Users\Http\Controllers\Api\UserController as RowboatUserController;

class UserController extends RowboatUserController
{
}
