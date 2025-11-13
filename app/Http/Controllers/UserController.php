<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
   public function index(){
    $users = User::all(); // elaquent query  *User
    return view('user.index', compact('users'));
   }
   public function create(){
      return view('user.create');
   }
   public function store(Request $request){
         $ValidatedData = $request->validate([
         'name' => 'required|string|max:255',
         'email'=> 'required|string|max:255',
         'password'=> 'required|string|max:255',

      ]);
      //hash password 
      $ValidatedData['password'] = Hash::make($ValidatedData['password']);
      
      User::create($ValidatedData);
      
      return redirect()->route('admin.user.index')->with('success','Data Pengguna (User) telah ditambahkan');
   }
   public function edit(User $user){
   return View('user.edit',compact('user'));
   }
   public function update(Request $request, User $user){
       $ValidatedData = $request->validate([
         'name' => 'required|string|max:255',
         'email'=> 'required|string|max:255',
         'password'=> 'required|string|max:255',

      ]);
      //hash password 
      $ValidatedData['password'] = Hash::make($ValidatedData['password']);
      
      $user->update($ValidatedData);
       return redirect()->route('admin.user.index')->with('success','Data Pengguna (User) telah diperbarui');
   }
   public function destroy(user $user){
      $user->delete();
      return redirect()->route('admin.user.index')->with('success','Data Pengguna (User) telah dihapus');
   }
  
}
