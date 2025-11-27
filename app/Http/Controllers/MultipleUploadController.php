<?php
namespace App\Http\Controllers;

use App\Models\MultipleUpload;
use Illuminate\Http\Request;

class MultipleUploadController extends Controller
{
    public function index($ref_table = null, $ref_id = null)
    {
        // Ambil file, bisa untuk semua atau filter per entitas
        $files = MultipleUpload::when($ref_table && $ref_id, function ($q) use ($ref_table, $ref_id) {
            $q->where('ref_table', $ref_table)->where('ref_id', $ref_id);
        })->get();

        return view('admin.pelanggan.upload_files', compact('files', 'ref_table', 'ref_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*'   => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
            'ref_table' => 'required|string',
            'ref_id'    => 'required|integer',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->storeAs('public/uploads', $filename);

                    MultipleUpload::create([
                        'filename'  => $filename,
                        'ref_table' => $request->ref_table,
                        'ref_id'    => $request->ref_id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Files uploaded successfully!');
    }

    // Store files specifically for a Pelanggan (helper for route)
    public function storeForPelanggan(Request $request, $id)
    {
        // attach ref_table and ref_id then reuse store logic
        // validate files
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                    // store in storage/app/public/uploads
                    $file->storeAs('public/uploads', $filename);

                    MultipleUpload::create([
                        'filename'  => $filename,
                        'ref_table' => 'pelanggan',
                        'ref_id'    => $id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Files uploaded successfully!');
    }

    public function destroy($id)
    {
        $file = MultipleUpload::findOrFail($id);

        // Hapus file dari storage
        \Storage::disk('public')->delete('uploads/' . $file->filename);

        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}
