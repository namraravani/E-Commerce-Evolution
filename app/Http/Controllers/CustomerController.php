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

    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Customer::query();

    if ($search) {
        $query->where('name', 'LIKE', "%$search%");
    }

    $customers = $query->latest()->paginate(5);

    Paginator::useBootstrap();

    return view('customer.index', compact('customers', 'search'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
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
