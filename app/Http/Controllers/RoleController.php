<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role_id === "viewer") {
            return back()->with("error", "Permissions insuffisantes");
        }
        $roles = Role::all();
        $countPermissions = Permission::count();
        return view("roles.index", [
            "roles" => $roles,
            "countPermissions" => $countPermissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create([
            "slug" => $request->id,
            "name" => $request->name,
        ]);
        if($role) {
            return redirect()->route("roles.index")->with("success", "Role crée avec succès");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        $roles = Role::all();
        $users = User::all()->diff($role->users);
        $countPermissions = Permission::count();
        return view("roles.show", [
            "role" => $role,
            "roles" => $roles,
            "users" => $users,
            "countPermissions" => $countPermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function editPermission(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $specificPermissionsGranted = $role->permissions;
        $specificPermissionsDenied = $permissions->diff($specificPermissionsGranted);
        return view("roles.editPermission", [
            "role" => $role,
            "permissionsGranted" => $specificPermissionsGranted,
            "permissionsDenied" => $specificPermissionsDenied
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $assigned = $request->input("assigned", []);
        foreach( $assigned as $assign) {
            $user = User::find($assign);
            $user->update([
                "role_id" => $role->id,
            ]);
        }

        return redirect()->route("roles.show", $id)->with("success", "Nouvelles assignations éffectuées");
    }

    public function updatePermissions(Request $request)
    {
        $id = $request->input("role_id");
        $role = Role::with("permissions")->find($id);
        $granted = $request->input("granted", []);
        $denied = $request->input("denied", []);
        if($granted) {
            $grantedValues = [];
            foreach($granted as $permissionGranted) {
                $role->permissions()->attach($permissionGranted);
                $grantedValues[] = $permissionGranted;
            }
        }
        if($denied) {
            $deniedValues = [];
            foreach($denied as $permissionDenied) {
                $role->permissions()->detach($permissionDenied);
                $deniedValues[] = $permissionDenied;
            }
        }
        // dd([
        //     "grant" => $grantedValues,
        //     "deny" => $deniedValues
        // ]);

        return redirect()->route("roles.editPermission", $role->id) ->with("success", "Modifications éffectuées avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
