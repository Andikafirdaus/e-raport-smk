<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel; // Kunci gudang Mapel

class MapelController extends Controller
{
    public function index()
    {
        $data_mapel = Mapel::all();
        return view('admin.mapel.index', compact('data_mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
        ]);

        Mapel::create($request->all());
        return redirect('/dashboard-admin/mapel');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());

        return redirect('/dashboard-admin/mapel');
    }

    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect('/dashboard-admin/mapel');
    }
}
