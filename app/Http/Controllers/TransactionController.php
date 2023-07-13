<?php

namespace App\Http\Controllers;

use App\Models\CategoryTicket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
        $totalQuantity = Order::where('status', 'success')->count();
        $totalPending = Order::where('status', 'pending')->count();
        $totalProduct = Ticket::count('name');
        $totalUser = User::count('id');
        $totalPrice = Order::where('status', 'success')->sum('total_price');
        $totalCategory = CategoryTicket::count('id');

        return view('order.index', [
            'order' => $order,
            'totalQuantity' => $totalQuantity,
            'totalPending' => $totalPending,
            'totalProduct' => $totalProduct,
            'totalUser' => $totalUser,
            'totalPrice' => $totalPrice,
            'totalCategory' => $totalCategory,
        ]);
    }

    // public function print()
    // {
    //     return view('order.print');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = Order::all();
        $totalQuantity = Order::where('status', 'success')->count();
        $totalPending = Order::where('status', 'pending')->count();
        $totalProduct = Ticket::count('name');
        $totalUser = User::count('id');
        $totalPrice = Order::where('status', 'success')->sum('total_price');
        $totalCategory = CategoryTicket::count('id');

        return view('order.create', [
            'order' => $order,
            'totalQuantity' => $totalQuantity,
            'totalPending' => $totalPending,
            'totalProduct' => $totalProduct,
            'totalUser' => $totalUser,
            'totalPrice' => $totalPrice,
            'totalCategory' => $totalCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
