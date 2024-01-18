<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    //
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('message', 'Role added successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();

        return redirect()->route('roles.index')->with('message', 'Role Edited successfully');
    }

    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function edit(Request $request,$id){
        try {
            $role = Role::findOrFail($id); // Find the role by its ID
            return response()->json(['roleName' => $role->name]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Role not found.'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id); // Find the role by its ID
            $role->delete(); // Delete the role

            // Redirect to the roles index page with a success message
            return redirect()->route('roles.index')->with('message', 'Role deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Role not found or could not be deleted');
        }
    }

}
