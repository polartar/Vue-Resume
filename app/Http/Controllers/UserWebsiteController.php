<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserWebsiteRequest;
use App\Models\UserWebsite;
use Illuminate\Http\Request;

class UserWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // No use as of yet
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No use as of yet
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserWebsiteRequest $request)
    {
        $validated = $request->validated();

        try {
            UserWebsite::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserWebsite  $userWebsite
     * @return \Illuminate\Http\Response
     */
    public function show(UserWebsite $userWebsite)
    {
        return response(['success' => 'true', 'resume' => $userWebsite], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserWebsite  $userWebsite
     * @return \Illuminate\Http\Response
     */
    public function edit(UserWebsite $userWebsite)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserWebsite  $userWebsite
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserWebsiteRequest $request, UserWebsite $userWebsite)
    {
        $validated = $request->validated();

        try {
            $userWebsite->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserWebsite  $userWebsite
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserWebsite $userWebsite)
    {
        try {
            $userWebsite->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
