<table class=" border">
	<tr>
    	<th class="headcol bg-white w-48 absolute border-b shadow-lg py-1 h-8 ">Employee Name</th>
    	<td class="px-24"></td>
        @for($i = 1; $i <= $now->daysInMonth; $i++)
            @php
                $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
            @endphp
            <td class='hover:bg-blue-400 px-4 py-1 bg-white font-semibold border-b-2 border-gray-700'>
                {{$date->format('d F Y')}}
            </td>
        @endfor
    </tr>
    @foreach($users as $user)
    <tr>
        <th class="headcol bg-white w-48 absolute border-b shadow-lg py-1 h-8 ">{{$user->name}}</th>
        <td class="px-24"></td>
        @for($i = 1; $i <= $now->daysInMonth; $i++)
            @php
                $date = Carbon\Carbon::parse($now->format('Y-m-').$i);
                $schedule = App\Models\Schedule::where('employee_id',$user->id)->whereDate('date',$date)->first();
            @endphp
            @if($schedule == null)
                <td class='hover:bg-blue-400 px-4 py-1 bg-red-200 border border-gray-700'>-</td>
            @elseif($schedule != null && $schedule->status != 'Not sign in')
                <td class='hover:bg-blue-400 px-4 py-1 bg-blue-200 border border-gray-700'>{{$schedule->shift_name}}</td>
            @else
                <td class='hover:bg-blue-400 px-4 py-1 bg-gray-200 border border-gray-700'>{{$schedule->shift_name}}</td>
            @endif
        @endfor
    </tr>
    @endforeach    
</table>