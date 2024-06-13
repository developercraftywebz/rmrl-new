<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function ()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
}
