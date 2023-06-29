<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

        return view('user.index', compact('users', 'search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function getUser(Request $request)
    {
        // Read value
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');

        $searchValue = $request->input('search.value');

        // Total records
        $totalRecords = User::count();

        // Apply search filter
        $filteredRecords = User::where('first_name', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records with pagination and search
        $records = User::where('first_name', 'like', '%' . $searchValue . '%')
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $data = [];
        $counter = $start + 1;

        foreach ($records as $record) {
            $row = [
                $counter,
                $record->role,
                $image = $record->image ? '<img src="' . asset($record->image) . '" alt="User Image" width="100">' : 'No Image',
                $record->first_name,
                $record->last_name,
                $record->email,

                '<a href="' . route('user.edit', $record->id) . '" class="btn"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;' .
                '<a href="' . route('user.show', $record->id) . '" class="btn"><i class="fa-solid fa-eye"></i></a>&nbsp;' .
                '<form action="' . route('user.destroy', $record->id) . '" method="POST" style="display:inline">
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
        $roles = Role::pluck('name')->toArray();
        return view('user.create',compact('roles'));
    }

    public function profile_view()
    {
        $user = Auth::user();
        $roles = Role::pluck('name')->toArray(); // Fetch all role names from the "roles" table

        return view('profile.profile', compact('user', 'roles'));
    }

    public function edit_profile(Request $request)
    {
        $userData = [
            'role' => $request->role,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'image' => null,
        ];

        $previousImage = Auth::user()->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'uploaded_images';
            $path = $image->move($destinationPath, $imageName);

            if ($previousImage) {
                File::delete(public_path($previousImage));
            }

            $userData['image'] = $path;
        } elseif ($request->has('delete_image')) {
            if ($previousImage) {
                File::delete(public_path($previousImage));
            }
            $userData['image'] = null;
        }

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update($userData);

        return redirect()->route('profile_view')
            ->with('success', 'Profile updated successfully.');
    }

    public function edit_password(Request $request, User $user)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'string', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
            'confirm_password' => 'required|same:new_password',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return response()->json(['error' => 'Incorrect old password']);
        }

        if ($request->old_password === $request->new_password) {
            return response()->json(['error' => 'Old and new passwords cannot be the same']);
        }

        $user = [
            'password' => Hash::make($request->new_password),
        ];

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update($user);

        return redirect()->route('profile_view')
            ->with('success', 'Profile updated successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $imagename = date('d-m-y') . "-" . $request->image->getClientOriginalName();
        $destinationPath = 'uploaded_images';
        $path = $request->image->move($destinationPath, $imagename);

        $user = new User();
        $user->role = $request->role;
        $user->image = $path;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($user->role);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name')->toArray();
        return view('user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',

        ]);

        $previousImage = $user->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'uploaded_images';
            $path = $image->move($destinationPath, $imageName);

            if ($previousImage) {
                File::delete(public_path($previousImage));
            }

            $user->image = $path;
        }

        $user->role = $request->role;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();
        $user->assignRole($user->role);

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        if ($user->image) {
            File::delete(public_path($user->image));
        }

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }


}
