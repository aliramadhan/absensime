<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\ListLeave;
use App\Models\Division;
use App\Models\User;
use App\Models\Request as RequestEmployee;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function updateSchedule(Request $request, $id)
    {
    	$schedule = Schedule::find($id);
        $shift = Shift::find($request->shift_id);
    	$cekSchedule = Schedule::where('employee_id',$request->employee_id)->whereDate('date',$request->date)->get();
    	if ($cekSchedule->count() <= 1) {
    		$schedule->update([
    			'date' => $request->date,
    			'shift_id' => $request->shift_id,
                'shift_name' => $shift->name
    		]);
    	}
    	else{
    		return redirect()->back()->with(['failure' => "Error, duplicate schedule at the same date."]);
    	}
		return redirect()->back()->with(['success' => "Success, Schedule updated."]);
    }
    public function destroySchedule($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule == null) {
            return redirect()->back()->with(['failure' => 'Shift not found.']);
        }
        $message = "Schedule ".$schedule->employee_name. " at ".Carbon::parse($schedule->date)->format('d F Y')." deleted successfully.";
        $schedule->delete();

        return redirect()->back()->with(['success' => $message]);
    }
    public function updateShift(Request $request, $id)
    {
        $shift = Shift::find($id);
        $cekShift = Shift::where('name',$request->name)->get();
        if ($cekShift->count() <= 1) {
            $shift->update([
                'name' => $request->name,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out
            ]);
        }
        else{
            return redirect()->back()->with(['failure' => "Error, duplicate Shift name."]);
        }
        return redirect()->back()->with(['success' => "Success, ".$shift->name." updated."]);
    }
    public function destroyShift($id)
    {
        $shift = Shift::find($id);
        if ($shift == null) {
            return redirect()->back()->with(['failure' => 'Shift not found.']);
        }
        $message = "Shift ".$shift->name. " deleted successfully.";
        $shift->delete();

        return redirect()->back()->with(['success' => $message]);
    }
    public function acceptRequestOvertime(Request $request, $id)
    {
        $cekRequest = RequestEmployee::find($id);
        if($cekRequest == null){
            return redirect()->back()->with(['failure' => "Error, request not found."]);
        }
        elseif($cekRequest->status != 'Waiting'){
            return redirect()->back()->with(['failure' => "Error, request already accepted/declined."]);
        }
        $cekRequest->update([
            'time' => $request->time,
            'status' => 'Accept'
        ]);
        return redirect()->back()->with(['success' => "Request overtime accepted."]);
    }
    public function activationUser(User $user)
    {
        if ($user == null) {
            return redirect()->back()->with(['failure' => "User not found."]);
        }
        else{
            if ($user->is_active == 0) {
                $user->update(['is_active' => 1]);
                return redirect()->back()->with(['success' => 'User '.$user->name.' activated.']);
            }
        }
    }
    public function updateLeave(Request $request, $id)
    {
        $leave = ListLeave::find($id);
        $is_annual = true;
        if ($request->is_annual == null) {
            $is_annual = false;
        }
        if ($request->name != $leave->name) {
            $this->validate($request,[
                'name' => 'required|string|unique:list_leaves',
                'duration' => 'required|numeric',
            ]);
        }
        else{
            $this->validate($request,[
                'name' => 'required|string',
                'duration' => 'required|numeric',
            ]);
        }
        $leave->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'is_annual' => $is_annual
        ]);
        return redirect()->back()->with(['success' => 'Leave '.$leave->name.' updated.']);
    }
    public function destroyLeave($id)
    {
        $leave = ListLeave::find($id);
        if ($leave == null) {
            return redirect()->back()->with(['failure' => 'Leave not found.']);
        }
        $message = "Leave ".$leave->name. " deleted successfully.";
        $leave->delete();

        return redirect()->back()->with(['success' => $message]);
    }
    public function updateDivision(Request $request, $id)
    {
        $division = Division::find($id);
        $cekDivision = Division::where('name',$request->name)->get();
        if ($cekDivision->count() <= 1) {
            $division->update([
                'name' => $request->name,
                'desc' => $request->desc,
            ]);
        }
        else{
            return redirect()->back()->with(['failure' => "Error, duplicate Division name."]);
        }
        return redirect()->back()->with(['success' => "Success, ".$division->name." updated."]);
    }
    public function destroyDivision($id)
    {
        $division = Division::find($id);
        if ($division == null) {
            return redirect()->back()->with(['failure' => 'Leave not found.']);
        }
        $message = "Leave ".$division->name. " deleted successfully.";
        $division->delete();

        return redirect()->back()->with(['success' => $message]);
    }
    public function destroyRequest($id)
    {
        $request = RequestEmployee::find($id);
        if ($request == null) {
            return redirect()->back()->with(['failure' => 'Request not found.']);
        }
        $message = "Request ".$request->type. " at ".Carbon::parse($request->date)->format('d F Y')." canceled successfully.";
        $request->delete();

        return redirect()->back()->with(['success' => $message]);
    }
    public function errorGPSNotActivated()
    {
        return view('errors.gps_not_activated');
    }
}
