<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AmbassadorController extends Controller
{
    public function index()
    {
        $ambassadors = User::ambassadors()->get();
        return response()->json($ambassadors, 200);
    }
}
