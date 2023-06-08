<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Product::all();
        return view('tickets.index', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryProduct::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'categories_id' => 'required|exists:category_product,id',
            'name' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
            'stock' => 'required|string',
            'price' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'description' => 'required|string'
        ]);

        Product::create([
            'categories_id' => $request->categories_id,
            'name' => $request->name,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'price' => $request->price,
            'image' => $request->hasFile('image') ?  $request->file('image')->store('public') : null,
            'description' => $request->description
        ]);

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = CategoryProduct::all();
        return view(
            'tickets.edit',
            compact('categories'),
            [
                'item' => $product,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'categories_id' => 'required|exists:category_product,id',
            'name' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
            'stock' => 'required|string',
            'price' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'description' => 'required|string'
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();
        $product->update($data);
        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('tickets.index');
    }
}
