<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPhoneRequest;
use App\Models\UserPhone;
use App\Models\Resume;
use Illuminate\Http\Request;

class UserPhoneController extends Controller
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
    public function store(StoreUserPhoneRequest $request)
    {
        $validated = $request->validated();

        $phone = UserPhone::where('phone_number', $validated['phone_number'])
            ->where('user_id', $validated['user_id'])
            ->first();


        // Avoid duplication
        if ($phone) {
            if($request->input('resume_id')) {
                Resume::where('id', $request->input('resume_id'))->update(
                    [
                        'user_phone_id' => $phone->id
                    ]
                );
            }
            return response(['success' => 'true', 'id' => $phone->id], 200);
        }

        try {
            $phone = UserPhone::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        if($request->input('resume_id')) {
            Resume::where('id', $request->input('resume_id'))->update(
                [
                    'user_phone_id' => $phone->id
                ]
            );
        }

        return response(['success' => 'true', 'id' => $phone->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPhone  $userPhone
     * @return \Illuminate\Http\Response
     */
    public function show($userPhoneId)
    {
        $phone = UserPhone::find($userPhoneId);
        if ($phone == null) {
            return response(['success' => 'false', 'userPhone' => $phone], 200);
        }
        return response(['success' => 'true', 'userPhone' => $phone], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPhone  $userPhone
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPhone $userPhone)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPhone  $userPhone
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserPhoneRequest $request, UserPhone $userPhone)
    {
        $validated = $request->validated();

        try {
            $userPhone->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPhone  $userPhone
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPhone $userPhone)
    {
        try {
            $userPhone->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
