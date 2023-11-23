<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Provinsi;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.master.provinsi.index', [
            'title' => 'Daftar Provinsi',
            'provinsis' => Provinsi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.master.provinsi.create', [
            'title' => 'Tambah Provinsi',
            'areas' => Area::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:100',
            'area_id' => 'required',
        ]);
        
        $validatedData['slug'] = SlugService::createSlug(Provinsi::class, 'slug', $request->nama);
        $validatedData['author_id'] = auth()->user()->id;
        
        Provinsi::create($validatedData);
        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi)
    {
        return view('dashboard.master.provinsi.show', [
            'title' => 'Detail Provinsi',
            'provinsi' => $provinsi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi)
    {
        return view('dashboard.master.provinsi.edit', [
            'title' => 'Perbarui Provinsi',
            'provinsi' => $provinsi,
            'areas' => Area::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:100',
            'area_id' => 'required',
        ]);
        
        $validatedData['slug'] = SlugService::createSlug(Provinsi::class, 'slug', $request->nama);
        $validatedData['author_id'] = auth()->user()->id;
        
        Provinsi::where('id', $provinsi->id)->update($validatedData);
        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();
        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil dihapus!');
    }
}
