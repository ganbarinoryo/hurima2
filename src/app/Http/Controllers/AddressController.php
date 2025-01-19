<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function address()
    {
        return view("purchase.address");
    }
}
