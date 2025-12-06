@extends('admin.layout')

@section('content')
<h1>Product Detail</h1>

<div class="card">
    <h2>{{ $product->name }}</h2>
    <p><strong>Store:</strong> {{ $product->store->name }}</p>
    <p><strong>Category:</strong> {{ $product->category->name }}</p>
    <p><strong>Price:</strong> Rp {{ number_format($product->price) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>

    <img src="/{{ $product->image }}" width="200" style="margin-top:20px;">
</div>

@endsection
