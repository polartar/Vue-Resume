<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserEmailRequest;
use App\Models\UserEmail;
use App\Models\Resume;
use Illuminate\Http\Request;

class UserEmailController extends Controller
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
    public function store(StoreUserEmailRequest $request)
    {
        $validated = $request->validated();

        $email = UserEmail::where('email', $validated['email'])
            ->where('user_id', $validated['user_id'])
            ->first();

        // Avoid duplication
        if ($email) {
            if($request->input('resume_id')) {
                Resume::where('id', $request->input('resume_id'))->update(
                    [
                        'user_email_id' => $email->id
                    ]
                );
            }
            return response(['success' => 'true', 'id' => $email->id], 200);
        }

        try {
            $email = UserEmail::create($validated);
            if($request->input('resume_id')) {
                Resume::where('id', $request->input('resume_id'))->update(
                    [
                        'user_email_id' => $email->id
                    ]
                );
            }
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $email->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserEmail  $userEmail
     * @return \Illuminate\Http\Response
     */
    public function show(UserEmail $userEmail)
    {
        return response(['success' => 'true', 'userEmail' => $userEmail], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserEmail  $userEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEmail $userEmail)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserEmail  $userEmail
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserEmailRequest $request, UserEmail $userEmail)
    {
        $validated = $request->validated();

        try {
            $userEmail->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserEmail  $userEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserEmail $userEmail)
    {
        try {
            $userEmail->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
