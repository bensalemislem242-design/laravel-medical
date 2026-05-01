<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScansController extends Controller
{
    /**
     * STORE SCAN
     */
    public function store(Request $request)
    {
        // ✅ VALIDATION
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'type'       => 'required|string|max:50',
            'scan_path' => 'required|file|mimes:jpg,jpeg,png,pdf,dcm',
        ]);

        // ✅ UPLOAD FILE
        $filePath = null;

        if ($request->hasFile('scan_path')) {

            $file = $request->file('scan_path');

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // storage in public/scans
            $file->move(public_path('scans'), $fileName);

            $filePath = 'scans/' . $fileName;
        }

        // ❗ IMPORTANT: SAVE TO DB
 Scan::create([
    'user_id'    => auth()->id(),   // 🔥 هذا المهم
    'patient_id' => $validated['patient_id'],
    'type'       => $validated['type'],
    'scan_path'  => $filePath,
]);

        return redirect()->back()->with('success', 'Scan ajouté avec succès');
    }

    /**
     * SHOW SINGLE SCAN (download)
     */
public function show($id)
{
    $scan = Scan::findOrFail($id);

    return view('scans.show', compact('scan'));
}


    /**
     * DELETE SCAN
     */
    public function destroy($id)
    {
        $scan = Scan::findOrFail($id);

        $file = public_path($scan->scan_path);

        if (file_exists($file)) {
            unlink($file);
        }

        $scan->delete();

        return redirect()->back()->with('success', 'Scan supprimé avec succès');
    }
}
