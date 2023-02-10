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

    public function create()
    {
     
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",2)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('role.update',compact('permission','rolePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
          // validator
          $this->validate($req, [
            'permission' => 'required',
        ]);
    
        try {
                 $role = Role::find(2);
    
        $role->syncPermissions($req->input('permission'));
     
    } catch (\Exception $e) {
        return $e->getMessage();
        }

    }
}
