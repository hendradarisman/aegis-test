<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\UserCreatedMail;
use App\Mail\AdminNotificationMail;

class UserController extends Controller
{
    
     // Create User API
     public function store(Request $request)
     {
         // validate input data
         $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:3|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
         try {
             // create new user
             $user = User::create([
                 'email' => $request->input('email'),
                 'password' => Hash::make($request->input('password')), // set hash password
                 'name' => $request->input('name'),
             ]);
             // send to user
            
                Mail::to($user->email)->send(new UserCreatedMail($user));
          
            
             // send to admin
             $adminEmail = 'hendradarisman34@gmail.com'; // change from env or db
             Mail::to($adminEmail)->send(new AdminNotificationMail($user));
 
             return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at->format('Y-m-d\TH:i:s\Z'),
            ]);
       
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'User creation failed',
                 'message' => $e->getMessage(),
             ], 500);
         }
     }
 
 
     // Get Users API
    public function index(Request $request)
{
    $query = User::query()
        ->where('active', true)
        ->withCount('orders');  // auto relasi, menyala abangku

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $sortBy = $request->input('sortBy', 'created_at');
    $query->orderBy($sortBy);

    $user = $query->paginate(10, ['id', 'email', 'name', 'created_at']);

    return response()->json([
        'page' => $user->currentPage(),
        'users' => $user->items(),
    ]);
}
}
