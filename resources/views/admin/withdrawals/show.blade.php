@extends('admin.layout')

@section('content')
<h1>Review Withdrawal</h1>

<div class="card">

<p><strong>Store:</strong> {{ $withdrawal->store->name }}</p>
<p><strong>Amount:</strong> Rp {{ number_format($withdrawal->amount) }}</p>
<p><strong>Status:</strong> {{ $withdrawal->status }}</p>

<form action="{{ route('admin.withdrawals.update',$withdrawal->id) }}" method="POST" style="margin-top:20px;">
    @csrf @method('PUT')

    <label>Update Status</label>
    <select name="status" style="padding:10px;width:100%;margin:10px 0;">
        <option value="pending" @selected($withdrawal->status=='pending')>Pending</option>
        <option value="approved" @selected($withdrawal->status=='approved')>Approved</option>
        <option value="rejected" @selected($withdrawal->status=='rejected')>Rejected</option>
    </select>

    <button style="padding:10px 20px;background:#FF7A00;color:white;border:none;border-radius:6px;">
        Update
    </button>
</form>

</div>
@endsection
