<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDeliveryController extends Controller
{
    //
    public function delivery()
    {
        // Fetch delivery data from the database
        $deliveries = []; // Replace with actual data fetching logic

        // Return the view with the delivery data
        return view('admin.deliveries', compact('deliveries'));
    }
}
