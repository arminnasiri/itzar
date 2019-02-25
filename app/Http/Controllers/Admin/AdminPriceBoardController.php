<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\PriceBoard;
use Illuminate\Http\Request;

class AdminPriceBoardController extends Controller
{
    public function index()
    {
        $pageTitle = Lang::get("labels.MainParts");
        $all_price= PriceBoard::all();
        return view('admin.Price_Board.index',compact('all_price','pageTitle'));
    }

    public function new_price ()
    {
        return view();
    }
    public function update(Request $request)
    {
    }
}
