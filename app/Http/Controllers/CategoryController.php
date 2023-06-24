<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection\links;


class CategoryController extends Controller
{

    public function index(Request $request)
{
    $query = Category::query();
    $categories = $query->latest()->paginate(5);
    Paginator::useBootstrap();


    return view('category.index', compact('categories'))
        ->with('i', ($categories->currentPage() - 1) * 5);
}


public function getCategory(Request $request)
{
    // Read values
    $draw = $request->input('draw');
    $start = $request->input('start');
    $length = $request->input('length');
    $searchValue = $request->input('search.value');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir');

    // Map column index to column name
    $columns = [
        0 => 'id',
        2 => 'name',
    ];
    $orderColumnName = $columns[$orderColumnIndex];

    // Total records
    $totalRecords = Category::count();

    // Apply search filter
    $filteredRecords = Category::where('name', 'like', '%' . $searchValue . '%')
        ->count();

    // Fetch records with pagination and search
    $query = Category::where('name', 'like', '%' . $searchValue . '%');

    $records = $query->orderBy($orderColumnName, $orderDir)
        ->skip($start)
        ->take($length)
        ->get();

    $data = [];
    $counter = $start + 1;

    foreach ($records as $record) {
        $status = $record->status == "1" ? '<span class="badge rounded-pill text-success bg-success text-light"><i class="fa-solid fa-circle-check"></i> Active</span>' : '<span class="badge rounded-pill text-danger bg-danger text-light"><i class="fa-solid fa-circle-xmark"></i> Inactive</span>';
        $image = $record->image ? '<img src="' . asset($record->image) . '" alt="Product Image" width="100">' : 'No Image';
        $row = [
            $counter,
            $image,
            $record->name,
            $status,

            '<a href="' . route('category.edit', $record->id) . '" class="btn"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;' .
            '<a href="' . route('category.show', $record->id) . '" class="btn"><i class="fa-solid fa-eye"></i></a>&nbsp;' .
            '<form action="' . route('category.destroy', $record->id) . '" method="POST" style="display:inline">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn"><i class="fa-solid fa-trash-can"></i></button>
            </form>'
        ];

        $data[] = $row;
        $counter++;
    }

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
    ];

    return response()->json($response);
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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Category_Images'), $imageName);
        }

        DB::table('categories')->insert([
            'name' => $request->name,
            'status' => $request->status,
            'image' => 'Category_Images/'.$imageName,

        ]);

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $previousThumbnail = $category->image;
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $thumbnailName = time() . "_" . $thumbnail->getClientOriginalName();
            $destinationPath = 'Category_Images';
            $path = $thumbnail->move($destinationPath, $thumbnailName);

            if ($previousThumbnail) {
                // Delete the previous thumbnail
                File::delete(public_path($previousThumbnail));
            }

            $category->image = $path;
        } elseif ($request->has('delete_thumbnail')) {
            // Delete the thumbnail if delete_thumbnail checkbox is selected
            if ($previousThumbnail) {
                File::delete(public_path($previousThumbnail));
            }
            $category->image = null;
        } else {
            // No new thumbnail selected and delete_thumbnail checkbox not selected, keep the previous thumbnail
            $category->image = $previousThumbnail;
        }

        $category->name = $request->name;
        $category->status = $request->status;
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
