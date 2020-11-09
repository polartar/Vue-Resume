<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\ElementCollectionException;

class ResumeController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $name = 'Untitled Resume';
        $resume = Resume::create([
            'user_id' => $user_id,
            'name'    => $name
        ]);
        return redirect(route('resume-builder', ['resume' => $resume->id]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResumeRequest $request)
    {
        $validated = $request->validated();

        try {
            Resume::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Resume $resume
     * @return \Illuminate\Http\Response
     */
    public function show(Resume $resume)
    {
        $resume = Resume::with([
            'user.user_addresses',
            'user.user_emails',
            'user.user_phones',
            'resumeSummaries',
            'resumeWorkExperiences.resumeDescriptions',
            'resumeEducations.educationDescriptions',
            'resumeDesign',
            'hobbies',
            'resumeSkill',
        ])->find($resume->id);

        return response(['success' => 'true', 'resume' => $resume], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Resume $resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Resume $resume
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeRequest $request, Resume $resume)
    {
        $validated = $request->validated();

        try {
            $resume->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Resume $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume)
    {
        try {
            $resume->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 200);
    }
}
