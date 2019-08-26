<?php

namespace App\API\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SKU;
use App\Component;
use App\Http\Requests as R;
use App\API\Resources\v1\SKUResource;

class SKUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SKUResource::collection(SKU::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(R\StoreSKURequest $request)
    {
        $components = Component::findOrFail($request->validated()['components']);

        $sku = auth()->user()->skus()->create($request->validated());

        $sku->components()->attach($components->pluck('id'));

        return new SKUResource($sku->load('components'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SKU $sku)
    {
        return new SKUResource($sku->load('components'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(R\UpdateSKURequest $request, SKU $sku)
    {
        $sku->update($request->validated());

        return new SKUResource($sku);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(R\DestroySKURequest $request, SKU $sku)
    {
        $sku->delete();

        return response()->json([], 200);
    }
}
