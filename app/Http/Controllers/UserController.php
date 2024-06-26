<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request) {
        $validatedData = $request->validate([
            'username'=> 'required|min:3|unique:users,username',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'address' =>'required',
            'picture' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $fileName = time().'.'.$request->picture->extension();  
            $request->picture->move(public_path('uploads'), $fileName);
            $validatedData['picture'] = 'uploads/' . $fileName;
        } else {
            $validatedData['picture'] = null;
        }

        $user = new User();
		$user->username = $validatedData['username'];
		$user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->address = $validatedData['address'];
        $user->picture = $validatedData['picture'] ?? null;

        $user->save();
        Auth::login($user);

        return redirect('/');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'username'=> 'required|min:3',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'address' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData['username'] !== $user->username) {
            $request->validate([
                'username' => 'unique:users,username',
            ]);
        }
    
        if ($request->hasFile('picture')) {
            $fileName = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->move(public_path('uploads'), $fileName);
            $validatedData['picture'] = 'uploads/' . $fileName;
    
            if ($user->picture && file_exists(public_path($user->picture))) {
                unlink(public_path($user->picture));
            }
        }
    
        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
    
        $user->username = $validatedData['username'];
		$user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->picture = $validatedData['picture'] ?? $user->picture;
    
        $user->save();
    
        return redirect('/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function register(){
        return view('register');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }
}
