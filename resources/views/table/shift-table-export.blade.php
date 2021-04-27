<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Time in</th>
            <th>Time out</th>
        </tr>
    </thead>
    <tbody>
    @foreach($shifts as $shift)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $shift->name }}</td>
            <td>{{ Carbon\Carbon::parse($shift->time_in)->format('H:i') }}</td>
            <td>{{ Carbon\Carbon::parse($shift->time_out)->format('H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>