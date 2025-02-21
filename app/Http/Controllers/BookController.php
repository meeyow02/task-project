<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $book = Book::all();
            return response()->json(new ResponseResource('Books retrieved successfully.', $book), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
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
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
        ]);

        try {
            Book::create([
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'tahun_terbit' => $request->tahun_terbit,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json(new ResponseResource('Book created successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // try {
        //     $book = Book::where('id', $id)->first();

        //     if (!$book) return response()->json(new ResponseResource('Book not found.', null), 404);

        //     return response()->json(new ResponseResource('Book retrieved successfully.', $book), 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'Gagal mendapatkan data: ' . $e->getMessage()
        //     ], 404);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request  $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
        ]);

        try {
            $book = Book::where('id', $id)->first();
            $book->update([
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'tahun_terbit' => $request->tahun_terbit,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json(new ResponseResource('Book updated successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mendapatkan data: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::where('id', $id)->first();

            $book->delete();

            return response()->json(new ResponseResource('Book deleted successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mendapatkan data: ' . $e->getMessage()
            ], 404);
        }
    }
}
