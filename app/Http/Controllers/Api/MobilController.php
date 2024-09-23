<?php

namespace App\Http\Controllers\Api;

use App\Enums\JenisMobil;
use App\Enums\Merk;
use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mobil::orderBy('jenis_mobil', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200); 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = [
            'jenis_mobil' => 'required|in:' . implode(',', array_column(JenisMobil::cases(), 'value')),
            'nama_mobil' => 'required|string',
            'merk' => 'required|in:' . implode(',', array_column(Merk::cases(), 'value')),
            'nopol' => 'required|string',
            'harga' => 'required|integer'
        ];
    


        $validator = Validator::make($request->all(), $validated);
        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menambahkan data',
                'data' => $validator->errors()
            ], 404);
        }

        $dataMobil = new Mobil;
        $dataMobil->jenis_mobil = $request->jenis_mobil;
        $dataMobil->nama_mobil = $request->nama_mobil;
        $dataMobil->merk = $request->merk;
        $dataMobil->nopol = $request->nopol;
        $dataMobil->harga = $request->harga;

        $dataMobil->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menambahkan Data',
            'data' => $dataMobil
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Mobil::find($id);
        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan berdasarkan ID',
                'data' => $data
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Mobil::find($id);

        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $data
            ], 404);
        }

        $rules = [
            'jenis_mobil' => 'required|in:' . implode(',', array_column(JenisMobil::cases(), 'value')),
            'nama_mobil' => 'required|string',
            'merk' => 'required|in:' . implode(',', array_column(Merk::cases(), 'value')),
            'nopol' => 'required|string',
            'harga' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat mengupdate data',
                'data' => $validator->errors()
            ], 404);
        }

        $data->jenis_mobil = $request->jenis_mobil;
        $data->nama_mobil = $request->nama_mobil;
        $data->merk = $request->merk;
        $data->nopol = $request->nopol;
        $data->harga = $request->harga;

        $post = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil di update',
            'data' => $data
        ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataMobil = Mobil::find($id) ;
        if(empty($dataMobil)) {
            response()->json([
                'status' => 'Failed',
                'message' => 'Data mobil tidak ditemukan'
            ],404);
        }
        $delMobil = $dataMobil->delete();

        return response()->json([
            'status' => 'Deleted',
            'message' => 'Data mobil berhasil di hapus'
        ], 200);
    }
}
