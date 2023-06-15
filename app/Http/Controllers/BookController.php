<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 5;
        return Book::paginate($limit);
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required|string|unique:books,fio',
            'phone' => 'required|string|unique:books,phone',
            'email' => 'required|email|unique:books,email',
            'birthday' => 'sometimes|nullable|date_format:Y-m-d',
        ]);
        $book = Book::create($request->except('_token'));
        return $book;
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        return $book = Book::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fio' => 'required|string|unique:books,fio,'.$id,
            'phone' => 'required|string|unique:books,phone,'.$id,
            'email' => 'required|email|unique:books,email,'.$id,
            'birthday' => 'sometimes|nullable|date_format:Y-m-d',
        ]);

        $book = Book::findOrFail($id);
        $book->fill($request->except(['id']));
        $book->save();
        return response()->json($book);
    }

    /**
     * Remove the specified resource.
     *
     */
    public function destroy(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        if($book->delete()) return response(null, 204);
    }
}
