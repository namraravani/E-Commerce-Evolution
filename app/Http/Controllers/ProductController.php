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
use App\Models\ProductImages;


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

    foreach ($records as $record) {
        $status = $record->status == "1" ? '<span class="badge rounded-pill text-success bg-success text-light">Active</span>' : '<span class="badge rounded-pill text-danger bg-danger text-light">Inactive</span>';
        $category = Category::find($record->category_id);
        $categoryname = $category ? $category->name :'n/A';

        $image = $record->image ? '<img src="' . asset('Product_thumbnails/' . $record->image) . '" alt="Product Image" width="100">' : 'No Image';

        $row = [
            $counter,
            $record->name,
            $record->brand,
            $record->code,
            $image,
            '$' . $record->price,
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'description' => 'required',
            'stock_quantity' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Product_thumbnails'), $imageName);
        }



        $product = new Product([
            'name' => $request->name,
            'brand' => $request->brand,
            'code' => $request->code,
            'image' => $imageName,
            'price' => $request->price,
            'description' => $request->description,
            'stock_quantity' => $request->stock_quantity,
            'status' => $request->status,
            'category_id' => $request->category_id,

        ]);

        $product->save();



// ...

        if ($request->hasFile("images")) {
            foreach ($request->file("images") as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("uploaded_images"), $imageName);
                $productImage = new ProductImages;
                $productImage->product_id = $product->id;
                $productImage->image = 'uploaded_images/'.$imageName;
                $productImage->save();
            }

        }

        return redirect()->route('product.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {

        $productImages = ProductImages::where('product_id', $product->id)->get();

        $categories = Category::all();

        return view('product.show', compact('product', 'productImages', 'categories'));

    }


    public function edit(Product $product)
{
    $productImages = ProductImages::where('product_id', $product->id)->get();

    $categories = Category::all();

    return view('product.edit', compact('product', 'productImages', 'categories'));
}


public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'brand' => 'required',
        'code' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'price' => 'required',
        'description' => 'required',
        'stock_quantity' => 'required',
        'status' => 'required',
        'category_id' => 'required|integer',
    ]);

    $previousImage = $product->image;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
        $destinationPath = public_path('Product_thumbnails');
        $path = $image->move($destinationPath, $imageName);

        if ($previousImage) {
            File::delete(public_path('Product_thumbnails/'.$previousImage));
        }

        $product->image = $imageName;
    } elseif ($request->has('delete_thumbnail')) {
        if ($previousImage) {
            File::delete(public_path('Product_thumbnails/'.$previousImage));
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
        $previousThumbnail = $product->image;

        if ($previousThumbnail) {
            $thumbnailPath = public_path('Product_thumbnails/' . $previousThumbnail);

            if (File::exists($thumbnailPath)) {
                File::delete($thumbnailPath);
            }
        }


        $productImages = $product->images;
        foreach ($productImages as $productImage) {
            $imagePaths = explode(',', $productImage->image);
            foreach ($imagePaths as $imagePath) {
                $imagePath = public_path($imagePath);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }


        $product->images()->delete();

        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Product deleted successfully');
    }

    public function delete($image)
    {
        $productImage = ProductImages::where('id', $image)->first();
        if ($productImage) {
            if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
            $productImage->delete();
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Image not found.');
        }
    }



public function storeImage(Request $request, $productId)
{
    // Validate the image file
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Retrieve the uploaded image file
    $imageFile = $request->file('image');

    // Generate a unique filename for the image
    $imageName = time() . '_' . $imageFile->getClientOriginalName();

    // Store the image file in the 'uploaded_images' folder
    $imageFile->move(public_path('uploaded_images'), $imageName);

    $productImage = new ProductImages;
    $productImage->image = 'uploaded_images/'.$imageName;
    $productImage->product_id = $productId;
    $productImage->save();

    // Create a new ProductImages instance


    return redirect()->back()->with('success', 'Image inserted successfully.');
}



}

