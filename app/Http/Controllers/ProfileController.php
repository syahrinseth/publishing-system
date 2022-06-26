<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = new UserResource(User::findOrFail(auth()->id()));

        if (request()->is('api/*')) {
            return response()->json($user);
        }

        $roles = Role::all();

        return Inertia::render('Profile/Edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);

        try {

            $user = User::findOrFail(auth()->id());
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->field = $request->field;
            $user->affiliation = $request->affiliation;
            $user->address_1 = $request->address_1;
            $user->address_2 = $request->address_2;
            $user->postcode = $request->postcode;
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

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
