@extends('layout.admin')
@section('search')
    <form action="{{ route('staff.search') }}"
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Seach for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <input type="submit" class="btn btn-primary" value="Search">
                {{-- <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button> --}}
            </div>
        </div>
    </form>
@endsection
@section('title')
    Danh sách nhân viên
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('staff.create') }}" class="btn btn-sm btn-primary shadow-sm">Add New
                                Staff</a>
                        </div>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Chi nhánh</th>
                            <th>Chức vụ</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Lương</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Chi nhánh</th>
                            <th>Chức vụ</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Lương</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($staffs as $staff)
                            <tr>
                                <td>{{$staff->id}}</td>
                                <td>{{$staff->name}}</td>
                                <td>{{$staff->hotel->name ?? 'N/A' }}</td>
                                <td>{{$staff->position}}</td>
                                <td>{{$staff->email}}</td>
                                <td>{{$staff->phone}}</td>
                                <td>{{$staff->salary}}</td>
                                <td>{{$staff->created_at}}</td>
                                <td>{{$staff->updated_at}}</td>
                                <td><a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $staff->id }}">
                                        Del
                                    </a>
                                </td>
                            </tr>

                            {{-- Modal DELETE --}}
                            <div class="modal fade" id="deleteModal{{ $staff->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel{{ $staff->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $staff->id }}">Xác Nhận Xóa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa nhân viên <strong>{{ $staff->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('staff.delete', $staff->id) }}" method="POST"
                                                style="display: inline;">
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
                {{ $staffs->links() }}
            </div>
        </div>
    </div>
    <script>
        // Kết nối với Pusher
        const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        const channel = pusher.subscribe('staff');
        channel.bind('App\\Events\\StaffCreated', function (data) {
            let tableBody = document.querySelector('tbody'); // Chọn tbody của bảng
            let newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>${data.staff.id}</td>
                <td>${data.staff.hotel_name ?? 'N/A'}</td>
                <td>${data.staff.name}</td>
                <td>${data.staff.position}</td>
                <td>${data.staff.email}</td>
                <td>${data.staff.phone}</td>
                <td>${data.staff.salary}</td>
                <td>${data.staff.created_at}</td>
                <td>${data.staff.updated_at}</td>
                <td>
                    <a href="/staff/edit/${data.staff.id}" class="btn btn-sm btn-primary">Edit</a>
                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal${data.staff.id}">Del</a>
                </td>
            `;

            tableBody.appendChild(newRow);
        });
    </script>
@endsection