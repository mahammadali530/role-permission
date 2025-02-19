<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only:['index']),
            new Middleware('permission:edit users', only:['edit']),
            new Middleware('permission:create users', only:['create']),
            new Middleware('permission:delete users', only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view ('users.list',[
            'users' => $users
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $roles = Role::orderBy('name', 'ASC')->get();
       return view('users.create',[
        'roles' => $roles
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    
       
        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }
    
        return redirect()->route('users.index')->with('success', 'User created successfully');
    
      }
  
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        $roles = Role::orderBy('name','ASC')->get();

        $hasRoles = $users->roles->pluck('id');
       
        return view ('users.edit',[
            'users' => $users,
            'roles' => $roles,
            'hasRoles' => $hasRoles
        ]);
    }
    
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);

      $validator = Validator::make($request->all(),[
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email,'.$id.',id'
      ]);

      if($validator->fails()){
        return redirect()->route('users.edit',$id)->withInput()->withError($validator);
      }

      $users->name = $request->name;
      $users->email = $request->email;
      $users->save();

      $users->syncRoles($request->role);

      return redirect()->route('users.index')->with('success', 'users update successfuly.');

    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
    
        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
        }
    
        return response()->json(['success' => false, 'message' => 'User not found!']);
    }
}
