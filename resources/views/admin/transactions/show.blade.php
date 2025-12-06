@extends('admin.layout')

@section('content')
<h1>Transaction Detail</h1>

<div class="card">

<p><strong>User:</strong> {{ $transaction->user->name }}</p>
<p><strong>Total:</strong> Rp {{ number_format($transaction->total_amount) }}</p>
<p><strong>Status:</strong> {{ $transaction->status }}</p>

<h3>Items:</h3>
<ul>
@foreach($transaction->items as $item)
    <li>{{ $item->product->name }} × {{ $item->quantity }}</li>
@endforeach
</ul>

</div>
@endsection
