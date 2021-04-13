<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Models\NiftyAssistant;
use App\Models\Token;
use App\Models\User;
use App\Services\UserService;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    private $userSvc;

    /**
     * AuthController constructor.
     * @param $userSvc
     */
    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'name'     => 'required|string',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }
        if (User::where('email', $request->input('email'))->exists()) {
            return response([
                'errors' => ['An account with this email ID already Exists']
            ], 422);
        }
        $user = $this->userSvc->store($request->all());
        $token = $user->createToken('Visionary Services Personal Access Client', ['is-user'])->accessToken;
        Token::updateOrCreate(
            ['user_id' => $user->id],
            ['token'   => $token]
        );
        $response = ['token' => $token];
        return response($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }
        if ($request->hasHeader('nifty')) {
            $client_name = 'Visionary Services Nifty Personal Access Client';
            $scope = 'is-nifty';
            $user = NiftyAssistant::where('email', $request->input('email'))->first();
            $column = 'nifty_assistant_id';
        } else {
            $client_name = 'Visionary Services Personal Access Client';
            $scope = 'is-user';
            $user = User::where('email', $request->input('email'))->first();
            $column = 'user_id';
        }

        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken($client_name, [$scope])->accessToken;
                Token::updateOrCreate(
                    [$column => $user->id],
                    ['token' => $token]
                );
                $response = ['token' => $token];
                return response($response);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }
}
