<?php

namespace App\Http\Controllers;

use App\Models\StoreLocation; // Import the StoreLocation model
use Illuminate\Http\Request;

class StoreLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all store locations from the database
        $stores = StoreLocation::all(); // Eloquent query to get all records

        // Pass the $stores data to the 'stores' view
        return view('stores', ['stores' => $stores]);
    }
}