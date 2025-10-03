<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;


class AdminUserTable extends Component
{
    public $search = '';
    public $role = '';
    public $status = '';

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->role) {
            $query->whereHas('roles', function($q) {
                $q->where('name', $this->role);
            });
        }

        if ($this->status !== '') {
            $query->where('active', $this->status === 'aktywny' ? 1 : 0);
        }

        $users = $query->get();
        $roles = Role::all();

        return view('livewire.admin-user-table', compact('users', 'roles'));
    }
}
