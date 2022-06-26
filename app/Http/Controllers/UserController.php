<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Filters\UserFilters;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    
    public function __construct()
    {
        if (!request()->is('api/*')) {
            $this->middleware('permission:users.show', ['only' => ['index', 'show', 'edit']]);
        }
        $this->middleware('permission:users.edit', ['only' => ['store', 'update']]);
        $this->middleware('permission:users.create', ['only' => ['create']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilters $userFilters)
    {
        $users = User::filter($userFilters);
        $users = new UserCollection($users->get());

        if (request()->is('api/*')) {
            return response()->json($users);
        }

        $data = [
            'users' => $users
        ];

        return Inertia::render('User/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return Inertia::render('User/Create', [
            'roles' => $roles
        ]);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        try {

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->affiliation = $request->affiliation;
            $user->address_1 = $request->address_1;
            $user->address_2 = $request->address_2;
            $user->postcode = $request->postcode;
            $user->field = $request->field;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->fax_no = $request->fax_no;
            $user->about = $request->about;
            $user->website_url = $request->website_url;
            $user->country = $request->country;
            if (!empty($request->roles) && count($request->roles) > 0) {
                $user->roles()->detach(); 
                $user->assignRole($request->roles);
            } else {
                $user->assignRole('User');
            }
            $user->password = bcrypt($request->password);
            $user->save();

        } catch(Exception $e) {

            if ($request->is('api/*')) {
                return response($e->getMessage(), 500)->json();
            }
    
            return abort(500, $e->getMessage());

        }

        if ($request->is('api/*')) {
            return response()->json(new UserResource($user));
        }

        return Redirect::route('user.edit', [
            'id' => $user->id
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
        $user = new UserResource(User::findOrFail($id));

        if (request()->is('api/*')) {
            return response()->json($user);
        }

        $roles = Role::all();

        return Inertia::render('User/Show', [
            'user' => $user,
            'roles' => $roles
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
        $user = new UserResource(User::findOrFail($id));

        if (request()->is('api/*')) {
            return response()->json($user);
        }

        $roles = Role::all();

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => $roles
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            // 'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        try {

            $user = User::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->affiliation = $request->affiliation;
            $user->address_1 = $request->address_1;
            $user->address_2 = $request->address_2;
            $user->postcode = $request->postcode;
            $user->field = $request->field;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->fax_no = $request->fax_no;
            $user->about = $request->about;
            $user->website_url = $request->website_url;
            $user->country = $request->country;
            if (!empty($request->roles) && count($request->roles) > 0) {
                $user->roles()->detach(); 
                $user->assignRole($request->roles);
            }
            // $user->password = bcrypt($request->password);
            $user->update();

        } catch(Exception $e) {

            if ($request->is('api/*')) {
                return response($e->getMessage(), 500)->json();
            }
    
            return abort(500, $e->getMessage());

        }

        if ($request->is('api/*')) {
            return response()->json(new UserResource($user));
        }

        return Redirect::route('user.edit', [
            'id' => $user->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();

        if (request()->is('api/*')) {
            return response('Success', 200)->json();
        }

        return Redirect::route('user.index');
    }

    /**
     * Profile controller.
     */
    public function profile()
    {
        $user = new UserResource(User::findOrFail(auth()->id()));

        if (request()->is('api/*')) {
            return response()->json($user);
        }

        $roles = Role::all();

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }
}
