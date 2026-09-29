@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">All Products ({{ $products->total() }})</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Add Product</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="table-responsive">
        <table class="table admin-table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $p->image_url }}" class="rounded-2" style="width:48px;height:48px;object-fit:cover" alt="">
                            <span class="fw-semibold">{{ $p->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $p->category->name }}</td>
                    <td>Rs. {{ number_format($p->price) }}</td>
                    <td>
                        @if($p->stock_quantity < 5)
                        <span class="badge bg-warning text-dark">⚠️ {{ $p->stock_quantity }}</span>
                        @else
                        <span class="text-muted">{{ $p->stock_quantity }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $p->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ $p->status }}</span>
                    </td>
                    <td>{{ $p->is_featured ? '⭐' : '—' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-outline-primary btn-sm me-1">Edit</a>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#del{{ $p->id }}">Delete</button>
                        {{-- Delete Modal --}}
                        <div class="modal fade" id="del{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-sm"><div class="modal-content">
                                <div class="modal-body text-center p-4">
                                    <p class="fw-bold mb-2">Delete "{{ $p->name }}"?</p>
                                    <p class="text-muted small mb-3">This action cannot be undone.</p>
                                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100 mb-2">Yes, Delete</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100" data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $products->links() }}</div>
@endsection
