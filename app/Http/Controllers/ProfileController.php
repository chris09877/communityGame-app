<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function index (){
        $user =Auth::user(); //with('posts')->find("ID");
        //dd($user);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }
        $userPosts = $user->posts()->get();
       // dd($userPosts);
        return view("profile",  ['user'=>$user,'userPosts'=>$userPosts]); //la retunr le view avec du user data tsb
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('updateUser', ['user' => $user]);


    }

//     public function update(Request $request)
// {
//     $user = User::find(Auth::id());

//     $user->name = $request->input('name');
//     $user->email = $request->input('email');
//     $user->bio = $request->input('Bio');

//     if ($request->hasFile('Avatar')) {
//         $file = $request->file('Avatar');
//         $filename = auth()->user()->id  . '.' . $file->getClientOriginalExtension();

//         $path = $file->store('avatars');
//  // Store the file in the public disk under the 'profiles' folder
//  $file->storeAs('profiles', $filename, 'public');    }
//  // Update the user's profile picture in the database
//  auth()->$user()->update(['profile_picture' => 'profiles/' . $filename]);
//     if ($request->has('status')) {
//         $status = $request->input('status');

//         if ($status == 'true') 
//         {
//             $user->admin = true;
//         } 
//         elseif ($status == 'false')
//         {
//             $user->admin = false;
//         }
//     }
//     $user->save();

//     return redirect()->route('profile')->with('success', 'User information updated successfully.');
// }

public function update(Request $request)
{
    $user = User::findOrFail($request->input('user'));

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->bio = $request->input('Bio');

    if ($request->hasFile('Avatar')) {
        $file = $request->file('Avatar');
        $filename = auth()->user()->id . '.' . $file->getClientOriginalExtension();

        // Store the file in the public disk under the 'avatars' folder
        $path = $file->storeAs('profiles', $filename, 'public');

        // Update the user's profile picture in the database
        $user->update(['avatar' => $path]);
       
    }

    if ($request->has('status')) {
        $status = $request->input('status');

        if ($status == 'true') {
            $user->admin = true;
        } elseif ($status == 'false') {
            $user->admin = false;
        }
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'User information updated successfully.');
}

}
