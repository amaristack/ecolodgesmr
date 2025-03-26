<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Http\Requests\StorePoolRequest;
use App\Http\Requests\UpdatePoolRequest;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch pools where 'cottage_type' is not null
        $pool = Pool::whereNotNull('cottage_type')->get();
        return view('user.user_cottage', compact('pool'));
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
    public function store(StorePoolRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        {
            $pool = Pool::findOrFail($id);
            $isAvailable = $pool->availability > 0;
            return view('user.user_view_cottage', [
                'pool' => $pool,
                'isAvailable' => $isAvailable
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pool $pool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoolRequest $request, Pool $pool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        //
    }
}
