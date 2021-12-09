<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterSuccessfully;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserLive extends Component
{
    //use LivewireAlert;
    public $users, $user, $name, $username, $email, $role, $division, $joined_at, $number, $address, $isModal, $divisions, $position;
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
            'username' => 'string|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'division' => 'required',
            'position' => 'required',
            'joined_at' => 'required|date',
        ]);
        $cekManager = User::where('roles','Manager')->where('division',$this->division)->first();
        if ($this->role == 'Manager' && $cekManager != null) {
            $this->addError('role', 'Manager at '.$this->division.' division already exist.');
        }
        else{
            $password = bin2hex(random_bytes(4));
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($password),
                'role' => 'Employee',
                'roles' => $this->role,
                'position' => $this->position,
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
            $this->alert('info', 'New '.$this->role . ' added successfully.', [
              'position' =>  'center', 
              'timer' =>  5000,
              'toast' =>  false, 
              'text' =>  '', 
            ]);
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
        $this->alert('info', 'Delete '.$user->name . ' deleted successfully.', [
          'position' =>  'center', 
          'timer' =>  5000,
          'toast' =>  false, 
          'text' =>  '', 
        ]);
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
                $this->alert('info', 'User '.$user->name.' activated.', [
                  'position' =>  'center', 
                  'timer' =>  5000,
                  'toast' =>  false, 
                  'text' =>  '', 
                ]);
            }
        }
        $this->emit('refreshLivewireDatatable');
    }
}
