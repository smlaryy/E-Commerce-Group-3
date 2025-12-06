@extends('admin.layout')

@section('content')
<h1>Transactions</h1>

<div class="card">

<table style="width:100%; border-collapse:collapse;">
<tr style="background:#f0f0f0;">
    <th>ID</th>
    <th>User</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>

@foreach($transactions as $t)
<tr>
    <td>{{ $t->id }}</td>
    <td>{{ $t->user->name }}</td>
    <td>Rp {{ number_format($t->total_amount) }}</td>
    <td>{{ $t->status }}</td>
    <td><a href="{{ route('admin.transactions.show',$t->id) }}">View</a></td>
</tr>
@endforeach

</table>

</div>
@endsection
