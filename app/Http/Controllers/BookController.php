<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        try {
            $book = Book::all();
            return response()->json(new ResponseResource('Books retrieved successfully.', $book), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

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

    public function update(Request  $request, $id)
    {
        $request->validate([
            'judul' => 'nullable',
            'penulis' => 'nullable',
            'tahun_terbit' => 'nullable',
            'deskripsi' => 'nullable',
        ]);

        try {
            $book = Book::where('id', $id)->first();
            $book->update($request->only(['judul', 'penulis', 'tahun_terbit', 'deskripsi']));

            return response()->json(new ResponseResource('Book updated successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update data: ' . $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::where('id', $id)->first();

            $book->delete();

            return response()->json(new ResponseResource('Book deleted successfully.', []), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete data: ' . $e->getMessage()
            ], 404);
        }
    }
}
