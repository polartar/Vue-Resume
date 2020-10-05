<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeSummaryRequest;
use App\Models\ResumeSummary;
use Illuminate\Http\Request;

class ResumeSummaryController extends Controller
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
    public function store(StoreResumeSummaryRequest $request)
    {
        $validated = $request->validated();

        try {
            ResumeSummary::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeSummary  $resumeSummary
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeSummary $resumeSummary)
    {
        return response(['success' => 'true', 'resume' => $resumeSummary], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeSummary  $resumeSummary
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeSummary $resumeSummary)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeSummary  $resumeSummary
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeSummaryRequest $request, ResumeSummary $resumeSummary)
    {
        $validated = $request->validated();

        try {
            $resumeSummary->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeSummary  $resumeSummary
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeSummary $resumeSummary)
    {
        try {
            $resumeSummary->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
