	<div class="bg-white shadow">
		<div class="flex gap-4 justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ">
			<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
				{{ __('Weekly Hours Report') }}
			</h2>



		</div>   

	</div>


  <div class="py-12">
  	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  		<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

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


        <livewire:tables.report-weekly>
  		</div>
  	</div>
  </div>



