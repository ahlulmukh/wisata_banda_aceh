<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\CategoryTicket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
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
        $categories = CategoryTicket::all();
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
            'lokasi' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        Ticket::create([
            'categories_id' => $request->categories_id,
            'name' => $request->name,
            'lokasi' => $request->lokasi,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->hasFile('image') ?  $request->file('image')->store('public') : null,
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
        $product = Ticket::find($id);
        $categories = CategoryTicket::all();
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
            'lokasi' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $product = Ticket::findOrFail($id);
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
        $product = Ticket::find($id);
        $product->delete();

        return redirect()->route('tickets.index');
    }
}
