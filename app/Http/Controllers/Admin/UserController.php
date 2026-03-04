<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $users = User::admin()->orderBy('name')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = true;
        $validated['is_active'] = $request->boolean('is_active');

        User::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário criado com sucesso.',
                'redirect' => route('admin.users.index')
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * Show the form for editing an admin user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário atualizado com sucesso.',
                'redirect' => route('admin.users.index')
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Change user password.
     */
    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Senha alterada com sucesso.'
            ]);
        }

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Senha alterada com sucesso.');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}
