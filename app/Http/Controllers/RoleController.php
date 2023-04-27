<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role-edit', ['only' => ['create', 'store']]);
    }

    public function index(): View
    {
        return view("Role.index")->with(["roles" => Role::all()]);
    }
    public function create(int $id): View
    {

        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('Role.update', compact('permission', 'rolePermissions', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, int $id): JsonResponse
    {
        // validator
        $this->validate($req, [
            'permission' => 'required',
        ]);

        try {
            $role = Role::find($id);

            $role->syncPermissions($req->input('permission'));

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'status' => 'success',
        ], 201);
    }
}
