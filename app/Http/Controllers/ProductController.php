<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateProductRequest;
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
        Inertia::share('parameters', [
            'page' => $request->page ?? '',
            'search' => $request->search ?? '',
            'category' => $request->category ?? ''
        ]);
        return Inertia::render('Products/List', [
            'categories' => Category::get(),
            'products' => $this->get($request)
        ]);
    }

    public function get(Request $request)
    {
        $search = $request->search;
        $category_id = $this->getCategorIdyByName($request->category);
        $products = Product::where('category_id', 'LIKE', "%{$category_id}%")
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

    public function validate(ValidateProductRequest $validationRequest)
    {
        $validationRequest->validated();
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
            'datetime' => date_format(date_create($request->datetime), 'Y-m-d H:i:s'),
        ]);
        
        return to_route('product.index');
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

        $category_id = $this->getCategorIdyByName($request->category);
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

    /**
     * Get category id by category name
     */
    private function getCategorIdyByName($name)
    {
        return Category::where('name',$name)->first()->id ?? '';
    }
}
