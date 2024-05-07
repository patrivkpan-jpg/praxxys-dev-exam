<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProductResource;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Products/ProductList', [
            'products' => $this->get($request)
        ]);
    }

    public function get(Request $request)
    {
        $search = $request->search;
        // TODO : Create shared function for getting category id by name
        $category = Category::where('name', $request->category)->first()->id ?? '';
        $products = Product::where('category_id', 'LIKE', "%{$category}%")
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->paginate(10);
        return ProductResource::collection($products);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,name',
            'datetime' => 'required|date'
        ]);

        $category_id = Category::where('name', $request->category)->first()->id ?? '';
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $category_id,
            'datetime' => $request->datetime,
        ]);
        return Inertia::render('Products/ProductList', [
            'products' => $this->get($request)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
