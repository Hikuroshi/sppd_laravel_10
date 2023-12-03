<?php

namespace App\Http\Controllers;

use App\Models\JenisPerdin;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class JenisPerdinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.master.jenis-perdin.index', [
            'title' => 'Daftar Jenis Perdin',
            'jenis_perdins' => JenisPerdin::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.master.jenis-perdin.create', [
            'title' => 'Tambah Jenis Perdin',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:100',
        ]);
        
        $validatedData['slug'] = SlugService::createSlug(JenisPerdin::class, 'slug', $request->nama);
        $validatedData['author_id'] = auth()->user()->id;
        
        JenisPerdin::create($validatedData);
        return redirect()->route('jenis-perdin.index')->with('success', 'Jenis Perdin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPerdin $jenis_perdin)
    {
        return view('dashboard.master.jenis-perdin.show', [
            'title' => 'Detail Jenis Perdin',
            'jenis_perdin' => $jenis_perdin,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPerdin $jenis_perdin)
    {
        return view('dashboard.master.jenis-perdin.edit', [
            'title' => 'Perbarui Jenis  Perdin',
            'jenis_perdin' => $jenis_perdin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPerdin $jenis_perdin)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:100',
        ]);
        
        $validatedData['slug'] = SlugService::createSlug(JenisPerdin::class, 'slug', $request->nama);
        $validatedData['author_id'] = auth()->user()->id;
        
        JenisPerdin::where('id', $jenis_perdin->id)->update($validatedData);
        return redirect()->route('jenis-perdin.index')->with('success', 'Jenis Perdin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPerdin $jenis_perdin)
    {
        $jenis_perdin->delete();
        return redirect()->route('jenis-perdin.index')->with('success', 'Jenis Perdin berhasil dihapus!');
    }
}
