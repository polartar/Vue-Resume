<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferableSkillRequest;
use App\Models\TransferableSkill;
use Illuminate\Http\Request;

class TransferableSkillController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransferableSkillRequest $request)
    {
        $validated = $request->validated();

        try {
            TransferableSkill::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TransferableSkill $transferableSkill
     * @return \Illuminate\Http\Response
     */
    public function show(TransferableSkill $transferableSkill)
    {
        return response(['success' => 'true', 'resume' => $transferableSkill], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TransferableSkill $transferableSkill
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferableSkill $transferableSkill)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferableSkill $transferableSkill
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTransferableSkillRequest $request, TransferableSkill $transferableSkill)
    {
        $validated = $request->validated();

        try {
            $transferableSkill->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TransferableSkill $transferableSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferableSkill $transferableSkill)
    {
        try {
            $transferableSkill->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
