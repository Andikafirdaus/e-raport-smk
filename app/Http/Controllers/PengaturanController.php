<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    /**
     * Tampilkan halaman pengaturan bobot penilaian.
     */
    public function index()
    {
        $bobotUh  = Pengaturan::getValue('bobot_uh', 40);
        $bobotPts = Pengaturan::getValue('bobot_pts', 30);
        $bobotPas = Pengaturan::getValue('bobot_pas', 30);

        return view('admin.pengaturan.index', compact('bobotUh', 'bobotPts', 'bobotPas'));
    }

    /**
     * Simpan perubahan bobot penilaian.
     */
    public function update(Request $request)
    {
        $request->validate([
            'bobot_uh'  => 'required|integer|min:0|max:100',
            'bobot_pts' => 'required|integer|min:0|max:100',
            'bobot_pas' => 'required|integer|min:0|max:100',
        ]);

        $total = $request->bobot_uh + $request->bobot_pts + $request->bobot_pas;
        if ($total !== 100) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Total bobot harus 100%. Saat ini total = {$total}%.");
        }

        $bobots = [
            'bobot_uh'  => $request->bobot_uh,
            'bobot_pts' => $request->bobot_pts,
            'bobot_pas' => $request->bobot_pas,
        ];

        foreach ($bobots as $key => $value) {
            Pengaturan::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('pengaturan.index')
            ->with('success', 'Bobot penilaian berhasil diperbarui!');
    }
}
