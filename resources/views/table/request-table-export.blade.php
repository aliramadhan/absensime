<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Employee</th>
            <th>date</th>
            <th>type Request</th>
            <th>desc Request</th>
            <th>time</th>
            <th>status</th>
            <th>request at</th>
        </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $request->employee_name }}</td>
            <td>{{ $request->date }}</td>
            <td>{{ $request->type }}</td>
            <td>{{ $request->desc }}</td>
            <td>{{ $request->time }}</td>
            <td>{{ $request->status }}</td>
            <td>{{ Carbon\Carbon::parse($request->created_at)->format('d F Y, H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>