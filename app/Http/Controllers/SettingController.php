<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResource;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\SettingCollection;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings.show', ['only' => ['index', 'show', 'edit']]);
        $this->middleware('permission:settings.edit', ['only' => ['create', 'edit', 'store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = new SettingCollection(Setting::all());

        if (request()->is('api/*')) {
            return response()->json($settings);
        }

        return Inertia::render('Setting/Index', [
            'settings' => $settings
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'manuscript_number_prefix' => 'required',
        ]);

        $settings = Setting::all();
        // update manuscript settings
        $manuscript_setting = $settings->where('type', Manuscript::class)
            ->where('name', 'manuscript_number_prefix')->firstOrFail();
        $manuscript_setting->value = $request->input('manuscript_number_prefix');
        $manuscript_setting->update();

        if ($request->is('api/*')) {
            return response()->json(new SettingResource($manuscript_setting));
        }

        return Redirect::route('setting.index', [
            'setting' => new SettingResource($manuscript_setting)
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
        //
    }
}
