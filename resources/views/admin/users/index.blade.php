@extends('layouts.admin')
@section('title', 'Customers')
@section('page-title', 'Customers')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">All Customers</h6>
        <span class="badge bg-success">{{ $users->total() }} total</span>
    </div>
    <div class="card-body p-0">
        @if($users->isEmpty())
        <div class="text-center py-5">
            <p style="font-size:3rem">👥</p>
            <h5 class="text-muted">No customers yet.</h5>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Orders</th>
                        <th>Registered</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $i => $user)
                <tr>
                    <td class="text-muted small">{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:.85rem;font-weight:700">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold small">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $user->email }}</td>
                    <td class="small text-muted">{{ $user->phone ?? '—' }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.orders', $user) }}" class="badge bg-success text-decoration-none">
                            {{ $user->orders_count }}
                        </a>
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-bag"></i> Orders
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
