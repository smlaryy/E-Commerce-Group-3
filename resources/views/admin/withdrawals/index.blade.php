@extends('admin.layout')

@section('content')
<h1>Withdraw Requests</h1>

<div class="card">
<table style="width:100%; border-collapse:collapse;">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Store</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($withdrawals as $w)
    <tr>
        <td>{{ $w->id }}</td>
        <td>{{ $w->store->name }}</td>
        <td>Rp {{ number_format($w->amount) }}</td>
        <td>{{ $w->status }}</td>
        <td>
            <a href="{{ route('admin.withdrawals.show',$w->id) }}">Review</a>
        </td>
    </tr>
    @endforeach

</table>
</div>
@endsection
