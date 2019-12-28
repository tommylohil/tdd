<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Book $book)
    {
        try {
            $book->checkin(auth()->user());
        }
        catch (\Exception $e) {
            return response([], 404);
        }
    }
}
