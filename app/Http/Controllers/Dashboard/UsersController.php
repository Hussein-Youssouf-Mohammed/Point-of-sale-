<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

   public function __construct()
   {
       $this->middleware(['permission:create-users'])->only('create');
       $this->middleware(['permission:read-users'])->only('index');
       $this->middleware(['permission:update-users'])->only('edit');
       $this->middleware(['permission:delete-users'])->only('destroy');
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->when($request->search, function($q) use ($request) {
            return $q->where('name' , 'like', '%'. $request->search . '%');
        })->latest()->paginate(4);

       return view('dashboard.users.index', [
           'users' => $users
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'image' => 'required',
            'permissions' => 'required'
        ]);

        
        $data = $request->except(['password','password_confirmation', 'permissions', 'image']);
        $image  = $request->image->store('uploads/users');
        $data['image'] = $image;
        $data['password'] = bcrypt($request->password);

        $user  = User::create($data);

        $user->attachRole('admin');
        $user->attachPermissions($request->permissions);
        session()->flash('success', __('site.added_successfully'));
       return  redirect(route("dashboard.users.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'image' => 'image',
            'permissions' => 'required'
        ]);

        $data = $request->except(['permissions', 'image']);
         
        if($request->hasFile('image')) {

           $image = $request->image->store('uploads/users');

            $data['image'] = $image;
            Storage::delete($user->image);

        }

        $user->update($data);

        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
       return  redirect(route("dashboard.users.index"));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('site.added_successfully'));
        return  redirect(route("dashboard.users.index"));
    }
}
