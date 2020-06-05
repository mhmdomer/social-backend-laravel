<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index() {
        $categories =  Category::all();
        return response(['data' => $categories, 'message' => 'success'], 200);
    }
}
