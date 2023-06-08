<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::query();
        $users = User::latest()->paginate(5);
        if ($search) {
            $query->where('name', 'LIKE', "%$search%");
        }

        $users = $query->latest()->paginate(1);
        Paginator::useBootstrap();

        return view('user.index',compact('users','search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('user.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',


        ]);

        $input = $request->all();




        User::create($input);

        return redirect()->route('user.index')
                        ->with('success','user created successfully.');
    }


    public function show(User $user)
    {
        return view('user.show',compact('user'));
    }


    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',


        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.index')
            ->with('success', 'user updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
                        ->with('success','user deleted successfully');
    }








}
