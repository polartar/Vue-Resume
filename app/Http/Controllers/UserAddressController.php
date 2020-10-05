<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
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
    public function store(StoreUserAddressRequest $request)
    {
        $validated = $request->validated();

        $address = UserAddress::where('user_id', $validated['user_id'])
            ->where('street_1', $validated['street_1'])
            ->where('street_2', $validated['street_2'])
            ->where('city', $validated['city'])
            ->where('province', $validated['province'])
            ->where('country', $validated['street_1'])
            ->where('postal_code', $validated['street_1'])
            ->first()
        ;

        // Avoid Duplication
        if ($address) {
            return response(['success' => 'true', 'id' => $address->id],200);
        }

        try {
            $address = UserAddress::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $address->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userAddress)
    {
        return response(['success' => 'true', 'userAddress' => $userAddress], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $userAddress)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserAddressRequest $request, UserAddress $userAddress)
    {
        $validated = $request->validated();

        try {
            $userAddress->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $userAddress)
    {
        try {
            $userAddress->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
