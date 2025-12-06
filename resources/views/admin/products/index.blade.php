@extends('admin.layout')

@section('content')
<h1>Products</h1>

<div class="card">

<table style="width:100%; border-collapse:collapse;">
    <tr style="background:#f0f0f0;">
        <th>ID</th>
        <th>Name</th>
        <th>Store</th>
        <th>Category</th>
        <th>Price</th>
        <th>Action</th>
    </tr>

    @foreach($products as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->store->name }}</td>
        <td>{{ $p->category->name }}</td>
        <td>Rp {{ number_format($p->price) }}</td>
        <td>
            <a href="{{ route('admin.products.show',$p->id) }}">Detail</a> |
            <a href="{{ route('admin.products.edit',$p->id) }}">Edit</a> |
            <form action="{{ route('admin.products.destroy',$p->id) }}"
                  method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button style="color:red;border:none;background:none;">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</div>
@endsection
