<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageService;
use App\Services\ProductPriceService;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

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
        $products = $this->priceService
            ->baseQueryWithCurrentPrice()
            ->with('categories', 'prices')
            ->paginate();
        $products = ProductResource::collection($products);

        return response()->paginate_resource($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // image code
        $file = $data['image'];
        $path = 'storage/' . $file->store('images', 'public');
        $data['image'] = $path;

        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        $product = Product::create($data);
        if ($categoryIds) {
            $product->categories()->sync($categoryIds);
        }
        $product->load('categories', 'prices');
        return response()->success($product);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)

    {
        $product = $this->priceService->baseQueryWithCurrentPrice()
            ->find($id);

        if (!$product) {
            return response()->errors('product not found');
        }

        $product->load('categories');
        $product = new ProductResource($product);

        return response()->success($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if (! $product) {
            return response()->errors('Product not found');
        }

        $data = $request->validated();
        $categoryIds = $data['category_ids'] ?? null;
        unset($data['category_ids']);

        if (isset($data['image'])) {
            $this->imageService->deleteProductImage($product->image);

            $file = $data['image'];
            $data['image'] = 'storage/' . $file->store('images', 'public');
        }

        $product->update($data);

        if ($categoryIds) {
            $product->categories()->sync($categoryIds);
        }
        $product->load('categories');
        return response()->success(new ProductResource($product));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->errors('Product not found');
        }

        $this->imageService->deleteProductImage($product->image);

        $product->delete();
        return response()->success('Product deleted successfully');
    }
}
