<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editPhone()
    {
        return view('auth.phone', ['user' => Auth::user()]);
    }
    public function updatePhone(Request $request)
    {
       
        $request->validate([
            'phone' => 'required|string|max:15|unique:users,phone',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('phone.edit')->with('success', 'บันทึกเบอร์โทรสำเร็จแล้ว!');
    }
}
