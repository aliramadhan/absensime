<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Employee</th>
            <th>Date</th>
            <th>Shift</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($schedules as $schedule)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $schedule->employee_name }}</td>
            <td>{{ $schedule->date }}</td>
            <td>{{ $schedule->shift_name }}</td>
            <td>{{ $schedule->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>