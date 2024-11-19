<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('auth.register',compact('roles'));
    }

    public function getUserRoleList()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles]);
    }

}
