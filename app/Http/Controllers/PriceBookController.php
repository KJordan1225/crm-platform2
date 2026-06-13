<?php

namespace App\Http\Controllers;

use App\Models\PriceBook;
use App\Models\PriceBookEntry;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceBookController extends Controller
{
    public function index()
    {
        $priceBooks = PriceBook::withCount('entries')
            ->latest()
            ->paginate(10);

        return view('price_books.index', compact('priceBooks'));
    }

    public function create()
    {
        return view('price_books.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePriceBook($request);

        PriceBook::create($validated);

        return redirect()
            ->route('price-books.index')
            ->with('success', 'Price book created successfully.');
    }

    public function show(PriceBook $priceBook)
    {
        $priceBook->load('entries.product');

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('price_books.show', compact('priceBook', 'products'));
    }

    public function edit(PriceBook $priceBook)
    {
        return view('price_books.edit', compact('priceBook'));
    }

    public function update(Request $request, PriceBook $priceBook)
    {
        $validated = $this->validatePriceBook($request);

        $priceBook->update($validated);

        return redirect()
            ->route('price-books.index')
            ->with('success', 'Price book updated successfully.');
    }

    public function destroy(PriceBook $priceBook)
    {
        $priceBook->delete();

        return redirect()
            ->route('price-books.index')
            ->with('success', 'Price book deleted successfully.');
    }

    public function addEntry(Request $request, PriceBook $priceBook)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'list_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        PriceBookEntry::updateOrCreate(
            [
                'price_book_id' => $priceBook->id,
                'product_id' => $validated['product_id'],
            ],
            [
                'list_price' => $validated['list_price'],
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return back()->with('success', 'Price book entry saved successfully.');
    }

    public function removeEntry(PriceBookEntry $priceBookEntry)
    {
        $priceBookEntry->delete();

        return back()->with('success', 'Price book entry removed successfully.');
    }

    private function validatePriceBook(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_standard' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
