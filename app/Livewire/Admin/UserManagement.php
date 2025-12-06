<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.admin')]
class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'table';
    public $showForm = false;
    public $editingUserId = null;

    public $userid = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $is_admin = false;

    public function render()
    {
        $users = User::where('userid', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
        ]);
    }

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->userid = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->is_admin = false;
        $this->editingUserId = null;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $id;
        $this->userid = $user->userid;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showForm = true;
    }

    public function save()
    {
        if ($this->editingUserId) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    private function createUser()
    {
        $validated = $this->validate([
            'userid' => 'required|unique:users,userid',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'is_admin' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        session()->flash('message', 'User created successfully.');
        $this->closeForm();
    }

    private function updateUser()
    {
        $user = User::findOrFail($this->editingUserId);

        $validated = $this->validate([
            'userid' => 'required|unique:users,userid,' . $this->editingUserId,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            'password' => $this->password ? 'min:6|confirmed' : '',
            'is_admin' => 'boolean',
        ]);

        if ($this->password) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        session()->flash('message', 'User updated successfully.');
        $this->closeForm();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }
}
