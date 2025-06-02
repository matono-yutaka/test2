<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $sort = $request->input('sort');
        switch ($sort) {
            case 'high':
                $query->orderBy('price', 'desc');
                break;
            case 'low':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(6)
                    ->appends($request->query());

        return view('index', [
            'products' => $products,
            'keyword'  => $keyword,
            'sort'     => $sort,
        ]);
    }

    public function create()
    {
        $seasons = Season::all();

        return view('create', [
            'seasons' => $seasons,
            'selectedSeasons' => [],
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/fruits-img', 'public');
            $data['image'] =basename($path);
        }

        $product = Product::create($data);

        $product->seasons()->attach($request->input('seasons'));

        return redirect('/products')->with('success', '商品を登録しました');
    }



    public function edit($id)
{
    $product = Product::with('seasons')->find($id);
    $seasons = Season::all();
    $selectedSeasons = $product->seasons->pluck('id')->toArray();

    return view('edit', compact('product', 'seasons', 'selectedSeasons'));
}


public function update(ProductRequest $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validated();

    if ($request->hasFile('image')) {
        $filename = $request->file('image')->store('images/fruits-img', 'public');
        $validated['image'] = basename($filename);
    }


    $product->update($validated);

    return redirect('/products')->with('success', '商品情報を更新しました');
}

public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect('/products')->with('success', '商品を削除しました。');
}




}
