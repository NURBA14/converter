<?php

namespace App\Http\Controllers;

use App\Service\Convert\V1\ConvertService;
use Illuminate\Http\Request;

class ConverterController extends Controller
{
    public function convert(Request $request, ConvertService $service)
    {
        return $service->load($request->all())->handle()->json();
    }

    public function index()
    {
        return view("index");
    }
    
    public function store(Request $request, ConvertService $service)
    {
        $response = $service->load($request->all())->handle()->php();
        return redirect()->back()->with("responseText", $response['data']['text']);
    }
}
