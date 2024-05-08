<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProductResource;
use Inertia\Inertia;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Products/List', [
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
            ->orderBy('id', 'desc')
            ->paginate(10);
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Form', [
            'categories' => Category::get()
        ]);
    }

    public function validate(Request $request)
    {
        $validate = [
            '1' => [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|exists:categories,name',
            ],
            '2' => [
                'images' => 'required',
                'images.*' => 'image'
            ],
            '3' => [
                'datetime' => 'required|date'
            ]
        ];
        $request->validate($validate[$request->step]);
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
            // TODO : Fix timezone bug
            'datetime' => date_format(date_create($request->datetime), 'Y-m-d H:i:s'),
        ]);
        
        return to_route('product.index');
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
    public function edit(int $id)
    {
        return Inertia::render('Products/Form', [
            'categories' => Category::get(),
            'product' => new ProductResource(Product::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:products',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|exists:categories,name',
            'datetime' => 'sometimes|date'
        ]);

        $category_id = Category::where('name', $request->category)->first()->id ?? '';
        if ($category_id !== '') {
            $data['category_id'] = $category_id;
        }
        $data['datetime'] = date_format(date_create($request->datetime), 'Y-m-d H:i:s');
        Product::find($request->id)
            ->update($data);

        return to_route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Product::find($id)
            ->delete();

        return to_route('product.index');
    }

}
