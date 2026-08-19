<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function create (Request $request){

        $roles = Role::all();

        $request->validate([
            'email'=>'required|email|unique:users,email',
            'name'=>'required|string',
            'password'=>[
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'role'=>['required', Rule::in($roles->pluck('name')->toArray())]
        ]);

        try{
            $user = User::create([
                'email'=>$request->email,
                'name'=>$request->name,
                'password'=>Hash::make($request->password),
            ]);

            if(!$user){
                return back()->with('failure', 'User creation failed');
            }

            $user->assignRole($request->role);

            LoggerService::log('Registration', auth()->user()->email, auth()->user()->name, 'Registered: ' . $request->email);

            return back()->with('success', 'User creation successful');
        } catch (\Exception $e){
            Log::alert('Failed to created user: ' . $e->getMessage());
            return back()->with('failure', 'Something went wrong, please try again later');
        }
    }
}
