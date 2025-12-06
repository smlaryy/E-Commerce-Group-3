@extends('admin.layout')

@section('content')
<h1>Users</h1>

<div class="card">

<table style="width:100%; border-collapse:collapse;">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->role }}</td>
    </tr>
    @endforeach

</table>

</div>
@endsection
