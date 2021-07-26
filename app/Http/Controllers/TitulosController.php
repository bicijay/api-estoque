<?php


namespace App\Http\Controllers;


class TitulosController extends Controller
{
    public function get()
    {
        return response()->json("Um titulo");
    }

    public function search()
    {
        return response()->json("lista de titulos");
    }
}
