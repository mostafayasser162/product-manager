<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageService;
use App\Services\ProductPriceService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(
        protected ProductPriceService $priceService,
        protected ImageService $imageService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch paginated products with current price, categories, and price history
        $products = $this->priceService
            ->baseQueryWithCurrentPrice()
            ->with('categories', 'prices')
            ->paginate();

        // Transform the products using the resource
        $products = ProductResource::collection($products);

        // Return paginated response
        return response()->paginate_resource($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        // Store the image and update the path in data
        $file = $data['image'];
        $path = 'storage/' . $file->store('images', 'public');
        $data['image'] = $path;

        // Create the product and attach categories
        $product = Product::create($data);

        if (!empty($categoryIds)) {
            $product->categories()->sync($categoryIds);
        }

        // Load relationships
        $product->load(['categories', 'prices']);

        // Return success response with transformed product
        return response()->success(new ProductResource($product));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the product with current price using the custom price service
        $product = $this->priceService
            ->baseQueryWithCurrentPrice()
            ->find($id);

        // Return error response if product not found
        if (! $product) {
            return response()->errors('Product not found');
        }

        // Load related categories and prices
        $product->load(['categories', 'prices']);

        return response()->success(new ProductResource($product));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $categoryIds   = $data['category_ids'] ?? [];
        $newImageFile  = $data['image'] ?? null;

        // Remove non-column keys before update
        unset($data['category_ids'], $data['image']);

        DB::transaction(function () use ($product, $data, $categoryIds, $newImageFile) {

            // Handle image upload and delete old one if needed
            if ($newImageFile) {
                // Upload new image
                $newImagePath = $newImageFile->store('images', 'public');
                $data['image'] = 'storage/' . $newImagePath;

                $this->imageService->deleteProductImage($product->image);
            }

            // Update product data
            $product->update($data);

            // Sync categories if provided
            if (!empty($categoryIds)) {
                $product->categories()->sync($categoryIds);
            }
        });

        // Load updated categories and return success response
        $product->load('categories');

        return response()->success(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->errors('Product not found');
        }

        DB::transaction(function () use ($product) {
            $imagePath = $product->image;

            // Delete product from database
            $product->delete();

            $this->imageService->deleteProductImage($imagePath);
        });

        return response()->success('Product deleted successfully');
    }
}
