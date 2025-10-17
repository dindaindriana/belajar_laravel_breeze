<?php

namespace App\Http\Controllers;

use App\Enums\StoreStatus;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use Illuminate\Routing\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Auth;

class StoreController extends Controller 
{
    public function list()
    {
        $stores = Store::query()
                // ->with('user', fn ($query) => $query->select(['id', 'name'])) //cara ini bisa juga
                ->with('user:id,name') //ini bisa juga dan lebih singkat
                ->latest()
                ->paginate(8);

        // return $stores;

        return view('stores.list', [
            'stores' => $stores,
            'isAdmin' => auth()->user()->isAdmin(), //seperti ini aklau dituliskan di contorller, yang awalnya kit atuliskan di view list.blade.php
        ]);
    }

    public function approve(Store $store)
    {
        $store->status = StoreStatus::ACTIVE;
        $store->save();

        return back();
    }

    public function mine(Request $request)
    {
        $stores = Store::query()
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(8);

        return view('stores.mine', [
            'stores' => $stores,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::query()
                ->where('status', StoreStatus::ACTIVE)
                ->latest()
                ->get();
                
        return view('stores.index',[
            'stores' => $stores,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stores.form',[
        'store' => new Store(),
        'page_meta' => [
                'title' => 'Create Store',
                'description' => 'Create new store for your business',
                'method' => 'post',
                'url' => route('stores.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if(!auth()->check()){
            return to_route('login');
        }

        $file = $request->file('logo');

        $request->user()->stores()->create([
            ...$request->validated(),
            ...['logo'=> $file->store('images/stores', 'public')],
        ]);

        // return back();
        return to_route('stores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return view('stores.show', [
            'store' => $store->loadCount('products'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Store $store)
    {
        Gate::authorize('update', $store); //ini manggil pakai policy

        return view('stores.form', [
            'store' => $store,
            'page_meta' => [
                'title' => 'Edit Store',
                'description' => 'Edit Store: ' . $store->name,
                'method' => 'put',
                'url' => route('stores.update', $store),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Store $store)
    {
        // Jika ada upload logo baru
        if ($request->hasFile('logo')){
            // Hapus file logo lama dari storage
            Storage::delete($store->logo);
            // Hapus file logo lama dari storage
            $file = $request->file('logo')->store('images/stores');
        } else {
            // Jika tidak upload logo, tetap pakai logo lama
            $file = $store->logo;
        }

        $store->update([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $file,
        ]);

        return to_route('stores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
    }
}
