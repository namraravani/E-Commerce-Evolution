<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use App\Models\{Country,State,City};

class CustomerController extends Controller
{

    public function index()
{
    // $page_box = $request->input('page_box');


    $query = Customer::query();



    $customers = $query->latest()->paginate(5);
    Paginator::useBootstrap();

    return view('customer.index', compact('customers'))
        ->with('i', ($customers->currentPage() - 1) * 5);
}

public function getCustomer(Request $request)
{


    // Read value
    $draw = $request->input('draw');
    $start = $request->input('start');
    $length = $request->input('length');

    $searchValue = $request->input('search.value');

    // Total records
    $totalRecords = Customer::count();

    // Apply search filter
    $filteredRecords = Customer::where('first_name', 'like', '%' . $searchValue . '%')
        ->count();

    // Fetch records with pagination and search
    $records = Customer::where('first_name', 'like', '%' . $searchValue . '%')
        ->orderBy('id', 'desc')
        ->skip($start)
        ->take($length)
        ->get();

    $data = [];
    $counter = $start + 1;

    foreach ($records as $record) {


        $row = [
            $counter,
            $image = $record->image ? '<img src="' . asset($record->image) . '" alt="Category Image" width="100">' : 'No Image',
    $record->first_name,
    $record->last_name,
    $record->email,
    $record->mobileno,
    $record->address,
    $record->country,
    $record->state,
    $record->city,
    $record->pincode,
            '<a href="' . route('customer.edit', $record->id) . '" class="btn"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;' .
            '<a href="' . route('customer.show', $record->id) . '" class="btn"><i class="fa-solid fa-eye"></i></a>&nbsp;' .
            '<form action="' . route('customer.destroy', $record->id) . '" method="POST" style="display:inline">
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




public function fetchstate(Request $request)
{

    $data['states'] = State::where('country_id', $request->country_id)->get(['name', 'id']);
    return response()->json($data);
}


    public function fetchcity(Request $request)
    {
        $data['cities'] = City::where('state_id',$request->state_id)->get(['name','id']);
        return response()->json($data);

    }


    public function create()
    {
        $data['countries'] = Country::get(['name', 'id']);
        return view('customer.create',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobileno' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',


        ]);

        $imagename= date('d-m-y')."-".$request->image->getClientOriginalName();
        $PriorPath=('uploaded_images');
        if(!$PriorPath){
            File::makeDirectory('uploaded_images');
        }
        $path = $request->image->move($PriorPath,$imagename);
        $country = Country::find($request->country);
        $state = State::find($request->state);
        $city = City::find($request->city);


        $customer = new Customer();
        $customer->image = $request->image;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->mobileno = $request->mobileno;
        $customer->address = $request->address;
        $customer->country = $country->name;
        $customer->state = $state->name;
        $customer->city = $city->name;
        $customer->pincode = $request->pincode;
        $customer->save();






        return redirect()->route('customer.index')
                        ->with('success','customer created successfully.');
    }


    public function show(Customer $customer)
    {
        return view('customer.show',compact('customer'));
    }


    public function edit(Customer $customer)
    {
        $data['countries'] = Country::get(['name', 'id']);

        return view('customer.edit',compact('customer'),$data);
    }


    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobileno' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',


        ]);

        $country = Country::find($request->country);
        $state = State::find($request->state);
        $city = City::find($request->city);

        $previousImage = $customer->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'uploaded_images';
            $path = $image->move($destinationPath, $imageName);

            if ($previousImage) {

                File::delete(public_path($previousImage));
            }

            $customer->image = $path;
        } elseif ($request->has('delete_image')) {

            if ($previousImage) {
                File::delete(public_path($previousImage));
            }
            $customer->image = null;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->mobileno = $request->mobileno;
        $customer->address = $request->address;
        $customer->country = $country->name;
        $customer->state = $state->name;
        $customer->city = $city->name;
        $customer->pincode = $request->pincode;


        $customer->save();

        return redirect()->route('customer.index')
            ->with('success', 'customer updated successfully.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')
                        ->with('success','user deleted successfully');
    }


}
