<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Requests\KegiatanRequest;
use ErrorException;
use Session;
use DB;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kegiatan = Kegiatan::all();
        return view('backend.website.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.website.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KegiatanRequest $request)
    {
        try {
            if ($request->image) {
                $image = $request->file('image');
                $nama_img = time() . "_" . $image->getClientOriginalName();
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'public/images/kegiatan';
                $image->storeAs($tujuan_upload, $nama_img);
            }

            $url = \Str::slug($request->nama);
            $kegiatan = new Kegiatan();
            $kegiatan->nama     = $request->nama;
            $kegiatan->slug     = $url;
            $kegiatan->image    = $nama_img ?? NULL;
            $kegiatan->content  = $request->content;
            $kegiatan->save();

            Session::flash('success', 'Kegiatan Berhasil ditambah !');
            return redirect()->route('backend-kegiatan.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::find($id);
        return view('backend.website.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if ($request->image) {
                $image = $request->file('image');
                $nama_img = time() . "_" . $image->getClientOriginalName();
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'public/images/kegiatan';
                $image->storeAs($tujuan_upload, $nama_img);
            }

            $url = \Str::slug($request->nama);
            $kegiatan = Kegiatan::findOrFail($id);
            $kegiatan->nama         = $request->nama;
            $kegiatan->slug         = $url;
            $kegiatan->image        = $nama_img ?? $kegiatan->image;
            $kegiatan->is_active    = $request->is_active;
            $kegiatan->content      = $request->content;
            $kegiatan->save();

            Session::flash('success', 'Kegiatan Berhasil diupdate !');
            return redirect()->route('backend-kegiatan.index');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id): RedirectResponse
    public function destroy($id)
    {

        // $kegiatan = Kegiatan::findOrFail($id);

        // // if ($kegiatan->nama) {
        // //     // kosongkan nama
        // //     $kegiatan->nama = null;
        // //     $kegiatan->save();
        // // }
        // // cek jika ada gambar
        // if ($kegiatan->image) {
        //     Storage::delete('public/images/kegiatan/' . $kegiatan->image);
        // }
        // // cek jika ada konten
        // // if ($kegiatan->content) {
        // //     // kosongkan konten
        // //     $kegiatan->content = null;
        // //     $kegiatan->save();
        // // }
        // $kegiatan->delete();
        // return redirect('kegiatan');
        // // ->route('kegiatan.index')
        // // ->with(['success' => 'Data Berhasil Dihapus!']);

        return "tes";
    }
}
    // {
    //     $kegiatan = nama::findOrFail($id);
    //     Storage::delete('public/images/kegiatan' . basename($kegiatan->image));
    //     $kegiatan->delete();
    //     return redirect()->route('kegiatan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    // }
    // public function destroy(string $id)
    // {

    // $kegiatan::where('id', $id)->delete();
    // return redirect()->to('kegiatan')->with('success', 'Berhasil Hapus Ektra Kulikuler');

    // $kegiatan = Kegiatan::find($id);
    // return view('backend.website.kegiatan.edit', compact('kegiatan'));

// }
