<?php
namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('owners.pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('owners')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = $request->user();
        
        // تحديث البيانات الأساسية
        $user->fill($validated);
        
        // معالجة الصورة إن وجدت
        if ($request->hasFile('image')) {
            $oldImage = public_path($user->image);
            // حذف الصورة السابقة إن وجدت
            if (!empty($user->image) && file_exists($oldImage)) {
                unlink($oldImage);
            }
            $path = 'images/owners/';
            // إنشاء المجلد إن لم يكن موجوداً
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }
            $image = $request->file('image');
            $filename = $user->name . time() . $image->getClientOriginalName();
            $image->move($path, $filename);
            $user->image = $path . $filename;
        }
        
        // معالجة كلمة المرور إن وجدت
        if ($request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $user->password = Hash::make($request->new_password);
        }

        $user->save();
        toast('تم تحديث تفاصيل الملف الشخصي بنجاح','success');
        return Redirect::back();
    }
    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

          $user = $request->user();
          $oldImage = public_path($user->image);

          if ($image = $request->file('image')){
              // حذف الصورة السابقة إن وجدت
              if (!empty($user->image) && file_exists($oldImage)) {
                  unlink($oldImage);
              }
              $path = 'images/users/';
              $filename = Auth::user()->name.time().$image->getClientOriginalName();
              $image->move($path, $filename);
              $user->image = $path.$filename;
          }
        // رفع الصورة الجديدة وحفظ المسار
        $user->save();
        toast('تم تحديث صورة الملف الشخصي بنجاح','success');
        return Redirect::back();
    }


    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        toast('تم تحديث كلمة المرور بنجاح','success');
        return back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
