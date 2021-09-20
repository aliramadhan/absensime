<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersActivated extends LivewireDatatable
{
    public $user;
    public function builder()
    {
        return User::where('role','Employee');
    }

    public function columns()
    {   
        return [
            Column::name('name')
                ->label('Employee Name'),
            Column::name('role')
                ->label('Role'),
            Column::name('division')
                ->label('Division'),
            Column::name('leave_count')
            /*
                ->label('Remain Annual Leave')->editable(),
            Column::callback(['is_active'], function ($is_active) {
                if ($is_active == 1) {
                    return 'Active';
                }
                return 'non-Active';
            })->label('Status'),
            Column::callback(['updated_at','is_active'], function ($updated_at,$is_active) {
                if ($is_active == 1) {
                    return '-';
                }
                $time = Carbon::parse($updated_at)->format('H:i, d F Y');
                return $time;
            })->label('Lock Time'),
            Column::callback(['id'], function ($id) {
                $user = User::find($id);
                if ($user->is_active == 0) {
                    return view('livewire.Admin.table_actions.table-action-user-activated', ['id' => $id, 'user' => $user]);
                }
            })->label('Action')*/
        ];
    }
    public function activatedUser($user)
    {
        $user = User::find($user['id']);
        if ($user == null) {
            session()->flash('failure', 'User not found.');
        }
        else{
            if ($user->is_active == 0) {
                $user->update(['is_active' => 1]);
                session()->flash('success', 'User '.$user->name.' activated.');
            }
        }
    }
}