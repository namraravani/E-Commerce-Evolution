<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Pagination\Paginator;
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

     // Fetch countries as name => id pairs

    return view('customer.index', compact('customers', 'search'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
}




public function fetchstate(Request $request)
{
    $countryId = $request->country_id;
    // Print the value of $countryId in the console
    
    $data['states'] = State::where('country_id', $countryId)->get(['name', 'id']);

    return response()->json($data);
}


    public function fetchcity(Request $request)
    {
        $data['cities'] = City::where('state_id',$request->state_id)->get(['name','id']);
        return response()->json($data);

    }


    public function create()
    {
        $data['countries'] = Country::get('name', 'id');
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

        $input = $request->all();




        Customer::create($input);

        return redirect()->route('customer.index')
                        ->with('success','customer created successfully.');
    }


    public function show(Customer $customer)
    {
        return view('customer.show',compact('customer'));
    }


    public function edit(Customer $customer)
    {
        return view('customer.edit',compact('customer'));
    }


    public function update(Request $request, Customer $customer)
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

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->mobileno = $request->mobileno;
        $customer->address = $request->address;
        $customer->country = $request->country;
        $customer->state = $request->state;
        $customer->city = $request->city;
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
