<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Http\Requests\StoreHallRequest;
use App\Http\Requests\UpdateHallRequest;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch halls where 'hall_name' is not null
        $hall = Hall::whereNotNull('hall_name')->get();
        return view('user.user_hall', compact('hall'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHallRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($hall_id)
    {
        $hall = Hall::findOrFail($hall_id);
        $isAvailable = $hall->availability > 0; // This should return a single Hall instance, not a collection.
        return view('user.user_show_hall', [
            'hall' => $hall,
            'isAvailable' => $isAvailable
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hall $hall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallRequest $request, Hall $hall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hall $hall)
    {
        //
    }
}
