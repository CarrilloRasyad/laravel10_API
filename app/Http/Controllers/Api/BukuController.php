<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul', 'asc')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=> $data
        ], 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataBuku = new Buku;
        
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal Menambahkan Data',
                'data' => $validator->errors()
            ], 404);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $dataBuku->save();
        
        return response()->json([
            'status' => 'Created',
            'message' => 'Data Berhasil di Tambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);
        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Id Ditemukan',
                'data' =>$data
            ], 200);
        } else {
            return response()->json([
                'status' =>false,
                'message' => 'Id tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Tidak dapat Mengupdate Data',
                'data' => $validator->errors()
            ]);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $dataBuku->save();
        
        return response()->json([
            'status' => 'Updated',
            'message' => 'Sukses melakukan update data'
        ], 201);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        
        $del = $dataBuku->delete();
        
        return response()->json([
            'status' => 'Deleted',
            'message' => 'Sukses menghapus data'
        ], 201);
    }
}
