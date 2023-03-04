<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class Roles extends Controller
{

    function __construct()
    {
         $this->middleware('permission:role-edit', ['only' => ['create','store']]);
    }


    public function index()
    {
        $roles = Role::all();

        $data = compact('roles');  
        return  view("Role.index")->with($data);  
    }
    public function create($id)
    {
     
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
            // $role = Role::get();
        return view('Role.update',compact('permission','rolePermissions','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req,$id)
    {
          // validator
          $this->validate($req, [
            'permission' => 'required',
        ]);
    
        try {
                 $role = Role::find($id);
    
        $role->syncPermissions($req->input('permission'));
     
    } catch (\Exception $e) {
        return $e->getMessage();
        }

    }
}
