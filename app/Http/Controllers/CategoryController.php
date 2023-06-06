<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = category::latest()->paginate(5);

        return view('category.index',compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();


        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        category::create($input);

        return redirect()->route('category.index')
                        ->with('success','category created successfully.');
    }


    public function show(Category $category)
    {
        return view('category.show',compact('category'));
    }


    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',

        ]);

        $input = $request->all();

        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the delete_image checkbox is checked
        if ($request->has('delete_image')) {
            // Delete the image from the folder
            if (Storage::disk('public')->exists('/images/'.$category->image)) {
                Storage::disk('public')->delete('/images/'.$category->image);
            }

            // Update the category's image column to null or any desired default image value
            $category->image = null; // or set it to your default image value
        }

        // Update the category's other fields
        $category->name = $request->name;
        $category->status = $request->status;

        // Check if a new image file is uploaded
        if ($request->hasFile('image')) {
            // Delete the existing image if present
            if (Storage::disk('public')->exists('/images/'.$category->image)) {
                Storage::disk('public')->delete('/images/'.$category->image);
            }

            // Upload and store the new image file
            $imagePath = $request->file('image')->store('images', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
                        ->with('success','category deleted successfully');
    }








}
