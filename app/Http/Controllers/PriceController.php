<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use App\Services\PriceService;
use App\Http\Resources\PriceResource;
use App\Http\Requests\Price\StorePriceRequest;
use App\Http\Requests\Price\UpdatePriceRequest;

class PriceController extends Controller
{
    public function __construct(private PriceService $priceService) {}

    public function store(StorePriceRequest $request, Product $product)
    {
        $data = $request->validated();

        // Check if there's already a price for this period
        if ($this->priceService->hasConflict($product->id, $data['start_date'])) {
            return response()->errors('There is already a price defined for this period.');
        }

        // Create new price
        $price = $product->prices()->create($data);

        return response()->success(new PriceResource($price));
    }

    public function update(UpdatePriceRequest $request, $id)
    {
        $price = Price::find($id);

        // Return error if price not found
        if (! $price) {
            return response()->errors('Price not found');
        }

        $data = $request->validated();

        // Check if updated start date causes a conflict with other prices
        if ($this->priceService->hasConflict($price->product_id, $data['start_date'], $price->id)) {
            return response()->errors('Another price exists for this period.');
        }

        // Update the price
        $price->update($data);

        return response()->success(new PriceResource($price));
    }

    public function destroy(Price $price)
    {
        $price->delete();

        return response()->success('Price deleted');
    }
}
