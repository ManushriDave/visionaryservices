<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Enums\Updater;
use App\Services\FileService;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var UserService
     */
    private $userSvc;
    private $fileSvc;

    /**
     * ProfileController constructor.
     * @param FileService $fileSvc
     * @param UserService $userSvc
     */
    public function __construct(
        FileService $fileSvc,
        UserService $userSvc
    ) {
        $this->userSvc = $userSvc;
        $this->fileSvc = $fileSvc;
    }

    public function index()
    {
        $user = auth()->user();
        return view('frontend.profile.index', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $success_msg = 'Something Went Wrong!';
        $error_msg = 'Something Went Wrong!';

        $data = $request->except([
            '_token',
            '_method',
        ]);

        if ($request->has(Updater::updateProfilePassword)) {
            $request->validate([
                'new_password' => 'confirmed',
                'password'     => 'required',
            ]);
            $success_msg = 'Password Updated!';
            $error_msg = 'Password Update Failed!';
        }

        if ($request->has(Updater::updateProfileBilling)) {
            $success_msg = 'Billing Updated!';
            $error_msg = 'Billing Update Failed!';
        }

        if ($request->has(Updater::updateProfileBasic)) {
            $request->validate([
                'email'       => 'email',
                'avatar_file' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ]);
            if ($request->hasFile('avatar_file')) {
                $data['avatar'] = $this->fileSvc->uploadFilePublicly($request->file('avatar_file'), 'avatars');
            }
            $success_msg = 'Profile Updated!';
            $error_msg = 'Profile Update Failed!';
        }

        $data['user_id'] = Auth::id();

        $update = $this->userSvc->update($data);

        if ($update) {
            flash($success_msg)->success();
        } else {
            flash($error_msg)->error();
        }
        return redirect(route('frontend.profile.index'));
    }
}
