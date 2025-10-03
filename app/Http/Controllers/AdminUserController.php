<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    // Wyświetlanie logów systemowych
    public function showSystemLogs(Request $request)
    {
        // Tylko administrator
        if (!auth()->user() || !auth()->user()->hasRole('Administrator')) {
            abort(403);
        }
        $logPath = storage_path('logs/laravel.log');
        $lines = [];
        if (file_exists($logPath)) {
            // Pobierz ostatnie 200 linii loga
            $lines = array_slice(file($logPath), -200);
        }
        return view('profile.system-logs', [
            'logLines' => $lines
        ]);
    }
    public function updateSystemName(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:255',
        ]);
        $name = $request->input('system_name');
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        $env = preg_replace('/^APP_NAME=.*$/m', 'APP_NAME="' . addslashes($name) . '"', $env);
        file_put_contents($envPath, $env);
        \Artisan::call('config:cache');
        \App\Services\AuditLogger::log('Zmieniono nazwę systemu', [
            'user_id' => auth()->id(),
            'new_name' => $name,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('admin.panel')->with('success', 'Nazwa systemu została zmieniona!');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'array',
            'active' => 'nullable|boolean',
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->active = $request->input('active', 0);
        $user->save();
        $user->syncRoles($request->input('roles', []));
        \App\Services\AuditLogger::log('Dodano nowego użytkownika przez admina', [
            'admin_id' => auth()->id(),
            'new_user_id' => $user->id,
            'new_user_email' => $user->email,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('admin.panel')->with('success', 'Użytkownik dodany!');
    }
    public function index()
    {
    $users = User::paginate(10);
    $roles = Role::all();
    $appLogo = \App\Models\Setting::get('app_logo');
    return view('profile.admin-panel', compact('users', 'roles', 'appLogo'));
    }

    public function showResetPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('profile.reset-password-user', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('profile.edit-user', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'array',
            'active' => 'boolean',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->syncRoles($request->input('roles', []));
        $user->active = $request->input('active', 0);
        $user->save();
        \App\Services\AuditLogger::log('Zaktualizowano użytkownika', [
            'admin_id' => auth()->id(),
            'edited_user_id' => $user->id,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('admin.panel')->with('success', 'Użytkownik zaktualizowany!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        \App\Services\AuditLogger::log('Usunięto użytkownika', [
            'admin_id' => auth()->id(),
            'deleted_user_id' => $user->id,
            'ip' => request()->ip(),
        ]);
        return redirect()->route('admin.panel')->with('success', 'Użytkownik usunięty!');
    }


    // Obsługa uploadu logo systemu
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,svg|max:1024',
        ]);
        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('logo', $filename, 'public');
        \App\Models\Setting::set('app_logo', 'storage/' . $path);
        \App\Services\AuditLogger::log('Zmieniono logo systemu', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
        ]);
        return redirect()->route('admin.panel')->with('success', 'Logo zostało zmienione!');
    }

    public function resetPassword($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'password' => 'required|string|min:6',
            ]);
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->route('admin.users.resetPassword', $user->id)->with('success', 'Hasło zostało zresetowane!');
        }
        return view('profile.reset-password-user', compact('user'));
    }
    // Czyszczenie cache aplikacji
    public function clearCache(Request $request)
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:cache');
        \Log::info('Admin wyczyścił cache przez panel.');
        session()->flash('success', 'Testowy komunikat: Cache został wyczyszczony!');
        return redirect('/admin-panel');
    }
}
