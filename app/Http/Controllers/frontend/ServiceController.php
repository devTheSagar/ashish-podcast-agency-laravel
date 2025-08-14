<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index($id){
        $service = Service::with('plans')->findOrFail($id);
        return view('frontend.services.index', [
            'service' => $service
        ]);
    }
}
