<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::where('user_id', Auth::id())->with('game')->get();
        return view('library.index', compact('libraries'));
    }
}