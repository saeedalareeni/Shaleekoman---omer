<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class PasswordResetController extends Controller
{
    private function resetType(Request $request): string
    {
        $type = $request->input('user_type', $request->session()->get('password_reset_user_type', 'customer'));

        return in_array($type, ['customer', 'owner'], true) ? $type : 'customer';
    }

    private function resetModel(string $type): string
    {
        return $type === 'owner' ? Owner::class : Customer::class;
    }

    public function sendCode(Request $request)
    {

        $request->validate([
            'email'        => 'required',
        ]);
        $type = $this->resetType($request);
        $model = $this->resetModel($type);

        if ($model::where('email', $request->email)->count() > 0) {
            $id = $model::where('email', $request->email)->pluck('id')->first();
            $user = $model::where('email', $request->email)->first();
            ResetPassword::where('user_id', $id)->where('user_type', $type)->delete();
            $code = mt_rand(100000, 999999);
            $resetCompanyAdmin = new ResetPassword();
            $resetCompanyAdmin->reset_code = $code;
            $resetCompanyAdmin->user_id = $id;
            $resetCompanyAdmin->user_type = $type;
            $resetCompanyAdmin->save();
            $data = [
                'user_name'=>'Dear '.$user->name .',',
                'title' => 'Please, reset your password by the check code copy',
                'title2' => 'Please kindly note that the code will be expired in 60 minutes',
                'code' => $code,
                'message' => 'This is a test email.'
            ];

            Mail::to($request->email)->send(new \App\Mail\ResetPassword($data));
            $request->session()->put('email', $request->email);
            $request->session()->put('password_reset_user_type', $type);
            return Redirect::route($type === 'owner' ? 'owner.code_verify_password' : 'user.code_verify_password');
        } else {
            $customErrors = [
                'email' => trans('back.Please_provide_exist_email_address'),
            ];

            return redirect()->back()
                             ->withErrors($customErrors)
                             ->withInput();
        }
    }
    public function checkCode(Request $request)
    {

            $request->validate([
                'reset_code'        => 'required',
            ]);
            $type = $this->resetType($request);
            if (ResetPassword::where('reset_code', $request->reset_code)->where('user_type', $type)->exists()) {
                $resetCode = ResetPassword::where('reset_code', $request->reset_code)->where('user_type', $type)->first();
                if ($resetCode->created_at < now()->subHour()) {
                    $resetCode->delete();
                    $customErrors = [

                        'reset_code' => 'code has been expired.',

                    ];

                    return redirect()->back()
                                     ->withErrors($customErrors)
                                     ->withInput();

                }
                else
                {
                    $user_id = ResetPassword::where('reset_code', $resetCode->reset_code)->where('user_type', $type)->pluck('user_id')->first();
                    $request->session()->put('checked', "true");
                    $request->session()->put('user_id', $user_id);
                    $request->session()->put('password_reset_user_type', $type);
                    return redirect()->back();
                }

            } else
            {

                $customErrors = [
                    'reset_code' => trans('back.The_code_wrong'),
                ];

                return redirect()->back()
                                 ->withErrors($customErrors)
                                 ->withInput();
            }

            // Find the reset code
    }

    public function handlePasswordForm(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|min:8',
            'confirm-password' => 'required|min:8|same:password',
        ]);

        $type = $this->resetType($request);
        $model = $this->resetModel($type);
        $user = $model::findOrFail($request->user_id);

        // Validate the request data
        // Update the user's attributes
        $user->password = Hash::make($request->password);
        $user->save();
        ResetPassword::where('user_id', $request->user_id)->where('user_type', $type)->delete();
        if ($request->session()->has('checked')) {
            $request->session()->forget('checked');
        }
        if ($request->session()->has('user_id')) {
            $request->session()->forget('user_id');
        }
        if ($request->session()->has('password_reset_user_type')) {
            $request->session()->forget('password_reset_user_type');
        }
        toast('تم تغيير كلمة المرور بنجاح','success');
        return Redirect::route($type === 'owner' ? 'owner.login' : 'login');
    }


}
