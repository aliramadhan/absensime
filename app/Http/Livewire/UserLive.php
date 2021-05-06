<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterSuccessfully;

class UserLive extends Component
{
    public $users, $user, $name, $email, $role, $division, $joined_at, $number, $address, $isModal, $divisions;
    public function render()
    {
        $this->users = User::where('is_active',0)->orderBy('updated_at','asc')->get();
        $this->divisions = Division::all();
        return view('livewire.Admin.user-live');
    }
    public function createUser()
    {
        $this->isModal = 'create';
    }
    public function closeModal()
    {
        $this->isModal = null;
    }
    public function storeUser()
    {
        //MEMBUAT VALIDASI
        $this->validate([
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'division' => 'required',
            'joined_at' => 'required|date',
        ]);
        $cekManager = User::where('role','Manager')->where('division',$this->division)->first();
        if ($this->role == 'Manager' && $cekManager != null) {
            $this->addError('role', 'Manager at '.$this->division.' division already exist.');
        }
        else{
            $password = bin2hex(random_bytes(4));
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($password),
                'role' => $this->role,
                'roles' => $this->role,
                'number' => $this->number,
                'address' => $this->address,
                'division' => $this->division
            ]);
            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password
            ];
            Mail::to($user->email)->send(new RegisterSuccessfully($data));
            session()->flash('success', 'New '.$this->role . ' added successfully.');
            $this->closeModal();
            $this->emit('refreshLivewireDatatable');
        }
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user == null) {
            session()->flash('failure', 'User not found.');
        }
        session()->flash('success', 'Delete '.$user->name . ' deleted successfully.');
        $user->delete();
        $this->emit('refreshLivewireDatatable');
    }
    public function activatedUser($id)
    {
        $user = User::find($user);
        if ($user == null) {
            session()->flash('failure', 'User not found.');
        }
        else{
            if ($user->is_active == 0) {
                $user->update(['is_active' => 1]);
                session()->flash('success', 'User '.$user->name.' activated.');
            }
        }
        $this->emit('refreshLivewireDatatable');
    }
}
