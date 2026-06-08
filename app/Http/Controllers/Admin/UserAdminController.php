<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $search = request('search');
        $role = request('role');
        
        $query = User::query();
        
        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }
        
        if ($role) {
            $query->where('role', $role);
        }
        
        $users = $query->paginate(15);
        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email'
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin',
            'status' => 'required|in:active,blocked',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>_+-]/',
            ],
        ], [
            'email.regex' => 'Email phải đúng định dạng và có đuôi tên miền hợp lệ (ví dụ: .com, .vn).',
            'password.min' => 'Mật khẩu phải dài ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải bao gồm cả chữ hoa, chữ thường, số và ký tự đặc biệt.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        $user->load('orders', 'reviews', 'wishlists');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email,' . $user->id
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin',
            'status' => 'required|in:active,blocked',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>_+-]/',
            ],
        ], [
            'email.regex' => 'Email phải đúng định dạng và có đuôi tên miền hợp lệ (ví dụ: .com, .vn).',
            'password.min' => 'Mật khẩu phải dài ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải bao gồm cả chữ hoa, chữ thường, số và ký tự đặc biệt.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting current user
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Cannot delete your own account');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function block(User $user)
    {
        $user->update(['status' => 'blocked']);
        return back()->with('success', 'User blocked');
    }

    public function unblock(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'User unblocked');
    }
}