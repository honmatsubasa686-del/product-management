<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Season;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        }

        if($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $seasons = Season::all();

        return view('products.create', compact('seasons'));
    }

    public function store(storeProductRequest $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');
        $product= Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        $product->seasons()->attach($request->season_ids);

        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $seasons = Season::all();

        $product->load('seasons');

        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        $product->seasons()->sync($request->season_ids);

        return redirect()->route('products.index');
    }
}
