<?php
namespace App\Http\Controllers;

use App\Models\MultipleUpload;
use App\Models\Pelanggan; // import model multiple uploads
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name', 'last_name', 'email', 'phone'];

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)->paginate(10);

        return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'birthday'   => 'nullable|date',
            // Enum values changed in migration to Indonesian labels
            'gender'     => 'nullable|in:Pria,Wanita,Lain-lain',
            'email'      => 'required|email|unique:pelanggan,email',
            'phone'      => 'nullable|string|max:20',
            'files.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ];

        $dataPelanggan = Pelanggan::create($data);

        // Upload files jika ada
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->storeAs('public/uploads', $filename);

                    MultipleUpload::create([
                        'filename'  => $filename,
                        'ref_table' => 'pelanggan',
                        'ref_id'    => $dataPelanggan->pelanggan_id,
                    ]);
                }
            }
        }

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);

        // Ambil semua file terkait pelanggan ini
        $files = MultipleUpload::where('ref_table', 'pelanggan')
            ->where('ref_id', $dataPelanggan->pelanggan_id)
            ->get();

        return view('admin.pelanggan.show', compact('dataPelanggan', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);

        // Ambil semua file terkait pelanggan ini
        $files = MultipleUpload::where('ref_table', 'pelanggan')
            ->where('ref_id', $dataPelanggan->pelanggan_id)
            ->get();

        return view('admin.pelanggan.edit', compact('dataPelanggan', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'birthday'   => 'nullable|date',
            'gender'     => 'nullable|in:Pria,Wanita,Lain-lain',
            'email'      => 'required|email|unique:pelanggan,email,' . $pelanggan->pelanggan_id . ',pelanggan_id',
            'phone'      => 'nullable|string|max:20',
        ]);

        $pelanggan->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
