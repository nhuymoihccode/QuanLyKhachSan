@extends('layout.admin')
@section('search')
<form action="{{ route('customer.search') }}"
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Seach for..."
            aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Search">
        </div>
    </div>
</form>
@endsection
@section('title')
Danh sách khách hàng
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary shadow-sm">Add New
                            Customer</a>
                    </div>
                    <tr>
                        <th>ID</th>
                        <th>Tài khoản tạo</th> <!-- Thêm cột -->
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SDT</th>
                        <th>Địa chỉ</th>
                        <th>Tiền đã thanh toán</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tài khoản tạo</th> <!-- Thêm cột -->
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SDT</th>
                        <th>Địa chỉ</th>
                        <th>Tiền đã thanh toán</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody id="customer-list">
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->user->name ?? 'N/A' }}</td> <!-- Hiển thị tên User -->
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ number_format($customer->total_paid, 0, ',', '.') }} VND</td>
                            <td>{{ $customer->created_at }}</td>
                            <td>{{ $customer->updated_at }}</td>
                            <td>
                                <a href="{{ route('customer.edit', $customer->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $customer->id }}">
                                    Del
                                </a>
                            </td>
                        </tr>
                        {{-- modal xóa --}}
                        <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $customer->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Xác Nhận Xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa khách hàng <strong>{{ $customer->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <form action="{{ route('customer.delete', $customer->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
</div>

<script>
    // Kết nối với Pusher
    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    const channel = pusher.subscribe('customer');
    channel.bind('App\\Events\\CustomerCreated', function (data) {
        let tableBody = document.getElementById('customer-list');
        let newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>${data.customer.id}</td>
            <td>${data.customer.user?.name ?? 'N/A'}</td> <!-- Thêm cột user -->
            <td>${data.customer.name}</td>
            <td>${data.customer.email}</td>
            <td>${data.customer.phone}</td>
            <td>${data.customer.address}</td>
            <td>${data.customer.total_paid ? Number(data.customer.total_paid).toLocaleString('vi-VN') + ' VND' : '0 VND'}</td>
            <td>${data.customer.created_at}</td>
            <td>${data.customer.updated_at}</td>
            <td>
                <a href="/customer/edit/${data.customer.id}" class="btn btn-sm btn-primary">Edit</a>
                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal${data.customer.id}">Del</a>
            </td>
        `;

        tableBody.appendChild(newRow);
    });
</script>
@endsection