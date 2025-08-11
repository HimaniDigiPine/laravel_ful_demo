<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\WelcomeUserMail;
use App\Mail\ActiveUserMail;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::withTrashed()->select(['id', 'firstname', 'lastname', 'name', 'email', 'phonenumber', 'role', 'is_active','deleted_at']);

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <form action="'.route('admin.users.restore', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().'
                                <button class="btn btn-sm btn-warning">Restore</button>
                            </form>
                            <form action="'.route('admin.users.forceDelete', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                            </form>
                        ';
                    } else {
                        $buttons .= '
                            <a href="'.route('admin.users.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                            <form action="'.route('admin.users.destroy', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">Delete</button>
                            </form>
                        ';
                    }
                    return $buttons;
                })
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->status === 'inactive' ? 'bg-danger' : 'bg-success';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->rawColumns(['action', 'status'])

                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname'   => 'required|string|max:100',
            'lastname'    => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'phonenumber' => 'required|string|max:15|unique:users,phonenumber',
            'role'        => 'required|in:user,staff,admin',
        ]);

        $password = Str::random(8);

        $user = User::create([
            'firstname'   => $request->firstname,
            'lastname'    => $request->lastname,
            'name'        => $request->firstname . ' ' . $request->lastname,
            'email'       => $request->email,
            'phonenumber' => $request->phonenumber,
            'role'        => $request->role,
            'is_active'   => 'active',
            'password'    => Hash::make($password),
        ]);

        // Send welcome email (you must configure your mail settings)
        Mail::to($user->email)->send(new WelcomeUserMail($user, $password));


        return response()->json([
            'message' => 'User created successfully.',
            'redirect' => route('admin.users.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        

        $request->validate([
            'firstname'   => 'required|string|max:100',
            'lastname'    => 'required|string|max:100',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phonenumber' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id)],
            'role'        => 'required|in:user,staff,admin',
            'is_active'        => 'required|in:active,inactive',
        ]);

        $user->update([
            'firstname'   => $request->firstname,
            'lastname'    => $request->lastname,
            'name'        => $request->firstname . ' ' . $request->lastname,
            'email'       => $request->email,
            'phonenumber' => $request->phonenumber,
            'role'        => $request->role,
            'is_active'   => $request->is_active,
        ]);



        if($request->is_active =="active")
        {
            
            Mail::to($user->email)->send(new ActiveUserMail($user));
        }

         return response()->json([
            'message' => 'User updated successfully.',
            'redirect' => route('admin.users.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User soft deleted.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', 'User restored successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.users.index')->with('success', 'User permanently deleted.');
    }
}
