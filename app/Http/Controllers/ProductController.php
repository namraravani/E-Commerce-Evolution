<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection\links;
use App\Models\{Category};


class ProductController extends Controller
{

    public function index(Request $request)
{

    $query = Product::query();
    $products = $query->latest()->paginate(5);
    Paginator::useBootstrap();
    return view('product.index', compact('products'))
        ->with('i', ($products->currentPage() - 1) * 5);
}


public function getProduct(Request $request)
{
    // Read value
    $draw = $request->input('draw');
    $start = $request->input('start');
    $length = $request->input('length');

    $searchValue = $request->input('search.value');

    // Total records
    $totalRecords = Product::count();

    // Apply search filter
    $filteredRecords = Product::where('name', 'like', '%' . $searchValue . '%')
        ->count();

    // Fetch records with pagination and search
    $records = Product::where('name', 'like', '%' . $searchValue . '%')
        ->orderBy('id', 'desc')
        ->skip($start)
        ->take($length)
        ->get();

    $data = [];
    $counter = $start + 1;

    foreach ($records as $record)
    {
        $status = $record->status == "1" ? '<span class="badge rounded-pill text-success bg-success text-light">Active</span>' : '<span class="badge rounded-pill text-danger bg-danger text-light">Inactive</span>';
        $category = Category::find($record->category_id);
        $categoryname = $category ? $category->name :'n/A';
        $row = [
            $counter,
            $record->name,
            $record->brand,
            $record->code,
            $image = $record->image ? '<img src="' . asset($record->image) . '" alt="Product Image" width="100">' : 'No Image',
            '$'.$record->price,
            $record->description,
            $record->stock_quantity,
            $status,
            $categoryname,
            '<a href="' . route('product.edit', $record->id) . '" class="btn"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;' .
            '<a href="' . route('product.show', $record->id) . '" class="btn"><i class="fa-solid fa-eye"></i></a>&nbsp;' .
            '<form action="' . route('product.destroy', $record->id) . '" method="POST" style="display:inline">
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
        $data['categories'] = Category::get(['name','id']);
        return view('product.create',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'code' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'description' => 'required',
            'stock_quantity' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $imagename= date('d-m-y')."-".$request->image->getClientOriginalName();
        $PriorPath=('uploaded_images');
        if(!$PriorPath){
            File::makeDirectory('uploaded_images');
        }
        $path = $request->image->move($PriorPath,$imagename);



        DB::table('products')->insert([
            'name' => $request->name,
            'brand' => $request->brand,
            'code' => $request->code,
            'image' => $path,
            'price' => $request->price,
            'description' => $request->description,
            'stock_quantity' => $request->stock_quantity,
            'status' => $request->status,
            'category_id' => $request->category_id,


        ]);
        return redirect()->route('product.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }


    public function edit(Product $product)
    {
        return view('product.edit',compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'code' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'description' => 'required',
            'stock_quantity' =>'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $previousImage = $product->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'uploaded_images';
            $path = $image->move($destinationPath, $imageName);

            if ($previousImage) {
                // Delete the previous image
                File::delete(public_path($previousImage));
            }

            $product->image = $path;
        } elseif ($request->has('delete_image')) {
            // Delete the image if delete_image checkbox is selected
            if ($previousImage) {
                File::delete(public_path($previousImage));
            }
            $product->image = null;
        }

        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->code = $request->code;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->stock_quantity = $request->stock_quantity;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->save();

        return redirect()->route('product.index')
            ->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')
                        ->with('success','product deleted successfully');
    }








}
