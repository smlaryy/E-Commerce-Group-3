@extends('admin.layout')

@section('content')
<h1>Stores</h1>

<div class="card">

<table style="width:100%; border-collapse:collapse;">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Name</th>
        <th>Owner</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($stores as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->user->name }}</td>
        <td>{{ $s->status }}</td>
        <td>
            <a href="{{ route('admin.stores.edit',$s->id) }}">Review</a>
        </td>
    </tr>
    @endforeach

</table>

</div>
@endsection
