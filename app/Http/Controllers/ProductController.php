<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:10000',
                'image' => 'required|file|extensions:png,jpeg',
                'description' => 'required|string|max:120',
                'season_ids' => 'required|array',
            ],
            [
                'name.required' => '商品名を入力してください',

                'price.required' => '値段を入力してください',
                'price.numeric' => '数値で入力してください',
                'price.min' => '0~10000円以内で入力してください',
                'price.max' => '0~10000円以内で入力してください',

                'image.required' => '画像を登録してください',
                'image.extensions' => '「.png」または「.jpeg」形式でアップロードしてください',

                'season_ids.required' => '季節を選択してください',

                'description.required' => '商品説明を入力してください',
                'description.max' => '120文字以内で入力してください',
            ]
        );

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
}
