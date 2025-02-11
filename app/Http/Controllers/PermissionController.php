<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\Permission;


class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only:['index']),
            new Middleware('permission:edit permissions', only:['edit']),
            new Middleware('permission:create permissions', only:['create']),
            new Middleware('permission:delete permissions', only:['destroy']),
        ];
    }
    //This is metod will show permission page
    public function index(){
        $permissions = Permission::orderBy('created_at','DESC')->paginate(5);
        return view('permissions.list',[
            'permissions' => $permissions
        ]);
    }

    //This is metod will creat permission page

    public function create(){
     return view('permissions.create');
    }

     //This is metod will insert a permission  DB

     public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required|unique:permissions|min:3'
        ]);
        if ($validator->passes()){
          Permission::create(['name' => $request->name]);
          return redirect()->route('permissions.index')->with('success', 'permissions added successfuly ');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }

     }

    
     //This is metod will edit a permission  page

     public function articaledit($id)
        {
            $permission = Permission::find($id);

            if (!$permission) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json(['data' => $permission], 200);
        }

     

     //This is metod will update a permission page

     public function update(Request $request, $id){
        $permission = Permission::find($id);
        if ($permission) {
            $permission->name = $request->name; 
            if ($permission->save()) {
                return response()->json(['success' => true, 'message' => 'Student updated successfully']);
            }
        }
        return redirect()->route('permissions.index')->with('success', 'permissions Update successfuly!');
 
     }

     //This is metod will delete a permission page

     public function deletee($id){
        $isdeleted = Permission::destroy(($id));
        if ($isdeleted) {
            session()->flash('success', 'permissions delete successfulye');
            return redirect('permissions');
        } else {
            return 'no deleted record';
        }
     }
}
