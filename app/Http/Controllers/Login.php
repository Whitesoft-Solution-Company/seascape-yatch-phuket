<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Laravel\Socialite\Facades\Socialite;

class Login extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
                // session(['key' => 'value']);

                session(['role' => 'user']);
            } else {
                // ตรวจสอบว่าผู้ใช้มีอยู่แล้วหรือไม่
                $user = User::firstOrCreate([
                    'google_id' => $googleUser->getId(),
                ], [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'phone' => null, // หรือใช้ข้อมูลเบอร์โทรที่ได้จาก Google ถ้ามี
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(16)), // สร้างรหัสผ่านสุ่มที่ปลอดภัย
                ]);



                // ทำการล็อกอินผู้ใช้
                Auth::login($user);
                session(['role' => 'user']);
            }

            if (is_null($user->phone)) {
                return redirect()->route('phone.edit'); // route ที่จะไปกรอกเบอร์โทร
            }

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout(); // ล็อกเอาต์ผู้ใช้ปัจจุบัน

        // ล้าง session เพื่อป้องกันปัญหาข้อมูลค้าง
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // เปลี่ยนเส้นทางกลับไปที่หน้าแรกหรือหน้าที่ต้องการ
        return redirect('/');
    }
}
