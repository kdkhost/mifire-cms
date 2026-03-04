<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of addresses.
     */
    public function index()
    {
        $addresses = Address::orderBy('sort_order')->get();

        return view('admin.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('admin.addresses.create');
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'      => ['required', 'string', 'max:255'],
            'address'    => ['required', 'string', 'max:500'],
            'complement' => ['nullable', 'string', 'max:255'],
            'city'       => ['required', 'string', 'max:255'],
            'state'      => ['required', 'string', 'max:2'],
            'zip_code'   => ['required', 'string', 'max:10'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'phone2'     => ['nullable', 'string', 'max:20'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Address::create($validated);

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Endereço criado com sucesso.');
    }

    /**
     * Show the form for editing an address.
     */
    public function edit(Address $address)
    {
        return view('admin.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            'label'      => ['required', 'string', 'max:255'],
            'address'    => ['required', 'string', 'max:500'],
            'complement' => ['nullable', 'string', 'max:255'],
            'city'       => ['required', 'string', 'max:255'],
            'state'      => ['required', 'string', 'max:2'],
            'zip_code'   => ['required', 'string', 'max:10'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'phone2'     => ['nullable', 'string', 'max:20'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $address->sort_order;

        $address->update($validated);

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Endereço atualizado com sucesso.');
    }

    /**
     * Remove the specified address.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Endereço excluído com sucesso.');
    }
}
