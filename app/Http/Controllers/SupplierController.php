<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class SupplierController extends Controller
{
    public function index()
    {
        $question = Question::where('active',true)->orderby('order_question','asc')->get();
        return view('suppliers.index',compact('question'));
    }
}
