<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;


class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        //Stock::create($request->all());
        //return redirect()->route('stocks.index');

        // Hanya masukkan atribut yang diizinkan
        Stock::create($request->only(['name', 'description']));
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        //$stock->update($request->all());
        //return redirect()->route('stocks.index');

        // Hanya masukkan atribut yang diizinkan
        $stock->update($request->only(['name', 'description']));
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {

        //return redirect()->route('stocks.index);
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }



}
