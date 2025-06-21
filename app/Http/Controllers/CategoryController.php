<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
      public function index()
    {
        //$categories = Category::with(['courses'])->get();
        $categories = Category::with(['courses'])->paginate(3);
        return CategoryResource::collection($categories);
    }


    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function show($id)
    {
        $category = Category::with(['courses'])->findOrFail($id);
        return new CategoryResource($category);
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:100',
        ]);

        $category->update($data);

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }
}
