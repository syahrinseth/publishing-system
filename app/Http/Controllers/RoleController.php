<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        if (request()->is('api/*')) {
            return response()->json([
                'roles' => $roles
            ]);
        }

        return Inertia::render('Role/Index', [
            'roles' => new RoleCollection($roles),
            'permissions' => $permissions
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Role/Create');
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
        ]);

        try {

            $role = new Role();
            $role->name = $request->name;
            $role->save();

        } catch(Exception $e) {

            if ($request->is('api/*')) {
                return response($e->getMessage(), 500)->json();
            }
    
            return abort(500, $e->getMessage());

        }

        if ($request->is('api/*')) {
            return response()->json(new RoleResource($role));
        }

        return Redirect::route('user.edit', [
            'role' => new RoleResource($role)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        if (request()->is('api/*')) {
            return response()->json($role);
        }

        return Inertia::render('Role/Show', [
            'role' => new RoleResource($role)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if (request()->is('api/*')) {
            return response()->json(new RoleResource($role));
        }

        return Inertia::render('Role/Edit', [
            'role' => new RoleResource($role)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {

            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $permissions = Permission::whereIn('id', $request->permissions)
                ->get();
            if (count($permissions) > 0) {
                $role->syncPermissions($permissions);
            }

        } catch (Exception $e) {

            if ($request->is('api/*')) {
                return response($e->getMessage(), 500)->json();
            }
    
            return abort(500, $e->getMessage());

        }

        if ($request->is('api/*')) {
            return response()->json(new RoleResource($role));
        }

        return Redirect::route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        if (request()->is('api/*')) {
            return response('Success', 200)->json();
        }

        return Redirect::route('role.index');
    }
}
