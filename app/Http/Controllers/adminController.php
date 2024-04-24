<?php

namespace App\Http\Controllers;

// use App\Models\User;
use App\Models\Admin_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    public function login(Request $request)
    {
        return view('admin/admin-log-in');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nume = 'Trusca Alexandru';
        $email = 'alextrusca1919@gmail.com';
        $password = Hash::make('193820');

        $admin = new Admin_Model();
        $admin->nume = $nume;
        $admin->email = $email;
        $admin->password = $password;
        $admin->save();

        // auth()->login($user);

        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // public function login(){
    //     return view('admin-log-in');
    // }

    public function authenticate(Request $request){

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->session()->regenerate();

            return redirect('admin');
        }
 
        return back()->withErrors([
            'email' => 'Credențiale greșite!',
        ])->onlyInput('email');

    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
