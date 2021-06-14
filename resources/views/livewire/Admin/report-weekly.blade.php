<div>
	<table>
		<thead>
			<tr>
				<th>Employee</th>
				<th>Weekly Hours</th>
				<th>Target Hours</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->name}}</td>	
				<td>{{$user->time_weekly}}</td>	
				<td>{{$user->target_weekly}}</td>	
				<td>
					@if($user->percent_weekly >= 100)
						Complete
					@elseif($user->percent_weekly <= 0)
						need Working
					@elseif($user->percent_weekly < 100)
						Less
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>
