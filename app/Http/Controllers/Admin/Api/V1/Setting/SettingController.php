<?php

namespace App\Http\Controllers\Admin\Api\V1\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Setting as SettingResource;
use App\Http\Resources\V1\SettingCollection;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SettingCollection
     */
    public function index()
    {
        return new SettingCollection(Setting::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Setting $setting
     * @return SettingResource
     */
    public function update(Request $request, Setting $setting)
    {
        return new SettingResource(tap($setting)->update($request->all()));
    }
}
