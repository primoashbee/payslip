<h1> <img src="{{public_path('logo.png')}}" /></h1>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payrolls as $payroll)
        <tr>
            <td>{{ $payroll->name }}</td>
            <td>{{ $payroll->email }}</td>
        </tr>
    @endforeach 
    </tbody>
</table>