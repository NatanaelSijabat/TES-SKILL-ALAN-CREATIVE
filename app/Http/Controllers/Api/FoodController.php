<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodStoreRequest;
use App\Http\Resources\FoodResource;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class FoodController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Food::all();

        return $this->sendResponse(FoodResource::collection($data), 'Data Food');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodStoreRequest $request, Food $food)
    {
        $food->nama = $request->nama;
        $food->harga = $request->harga;

        if ($request->file('foto')) {
            $food->foto = $request->file('foto')->store('food', 'public');
        }

        if ($food->save()) {
            return $this->sendResponse(new FoodResource($food), 'Data Berhasil Ditambah');
        } else {
            return $this->sendError('Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Food::find($id);

        if (!$data)
            return $this->sendError('Data tidak ditemukan');

        return $this->sendResponse(new FoodResource($data), 'Data Food By Id');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodStoreRequest $request, string $id)
    {
        $food = Food::find($id);

        $path = public_path("storage\\" . $food->foto);
        $filename = "";

        if ($request->hasFile('foto')) {
            if (File::exists($path)) {
                File::delete($path);
            }
            $filename = $request->file('foto')->store('food', 'public');
        } else {
            $filename = $request->foto;
        }

        $food->nama = $request->nama;
        $food->harga = $request->harga;
        $food->foto = $filename;

        $result = $food->save();

        if ($result) {
            return $this->sendResponse($food, "Data Berhasil Diupdate");
        } else {
            return $this->sendError("Gagal");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = Food::find($id);

        $fotoLama = $food->foto;

        if ($fotoLama) {
            Storage::delete($fotoLama);
        }

        if ($food->delete()) {
            return $this->sendResponse([], 'Data berhasil dihapus');
        } else {
            return $this->sendError('Data gagal dihapus');
        }
    }
}
