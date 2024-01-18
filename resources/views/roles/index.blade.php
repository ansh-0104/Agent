@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<style>
    .error {
  background-color: #FEE;
  border: 1px solid #EDD;
  color: #A66;
}
</style>


<style>
    .btn-primary {
    --bs-btn-color: #fff;
    --bs-btn-bg: #1c3d6d !important;
    --bs-btn-border-color: #1c3d6d;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #0952bc;
    --bs-btn-hover-border-color: #0952bc;
    --bs-btn-focus-shadow-rgb: 49, 132, 253;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #0952bc;
    --bs-btn-active-border-color: #0a53be;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #0d6efd;
    --bs-btn-disabled-border-color: #0d6efd;
}
.fas{
    color: #1c3d6d;
    font-size: large;
    padding: 4px;
    cursor: pointer;
}
.dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    /* border: 2px solid grey; */
    border-radius: 10px;
    background: #1c3d6d;
    color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #000 !important;
    background: #c0c2c6 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #fff !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
}


.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #fdf0f0 !important;
    background: #c0c2c6 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
    outline: none;
    background-color: #2b2b2b;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2b2b2b), color-stop(100%, #0c0c0c));
    background: -webkit-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
    background: -moz-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
    background: -ms-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
    background: -o-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
    background: linear-gradient(to bottom, #2b2b2b 0%, #0c0c0c 100%);
    box-shadow: inset 0 0 3px #111;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #585858;
    border-radius: 9px;
    background-color: #585858;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111));
    background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
    background: -moz-linear-gradient(top, #585858 0%, #111 100%);
    background: -ms-linear-gradient(top, #585858 0%, #111 100%);
    background: -o-linear-gradient(top, #585858 0%, #111 100%);
    background: linear-gradient(to bottom, #585858 0%, #111 100%);
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    *cursor: hand;
    color: #fff !important;
    border: 1px solid transparent;
    border-radius: 2px;
}

</style>


<div class="container">
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@error('name')
<div class="alert error">
{{ $message }}
</div>
@enderror
    <h2>Roles</h2>
    <div class="row">
    <div class="col-9">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#roleModal">
        Add Role
    </button>
    </div>
    </div>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="  edit-role" data-toggle="modal" data-target="#roleEdit" data-id="{{ $role->id }}">
                        <i class="fas fa-pencil-alt"></i>
</a>
                        <a class="  delete-role" data-toggle="modal" data-target="#deleteRoleModal" data-id="{{ $role->id }}">
                        <i class="fas fa-trash"></i>
</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Add/Edit Role</h5>
                <button type="button" class="close btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="roleForm" action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" id="role_id"> -->
                    <div class="form-group">
                        <label for="name">Role Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="roleEdit" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Add/Edit Role</h5>
                <button type="button" class="close btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="roleForm" action="{{ route('roles.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="role_id"> <!-- Hidden input for role ID -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Role Name:</label>
                        <input type="text" name="name" id="name1" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveRoleButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                <button type="button" class="close btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this role?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteRoleForm" action="{{ route('roles.destroy', 0) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
</div>

<script>
    $('.edit-role').on('click', function() {
            var roleId = $(this).data('id');
            var roleName = $(this).data('name'); // Retrieve the role name
            $('#role_id').val(roleId);
            $.ajax({
                type: 'GET',
                url: '/get-role/' + roleId, // Replace with your actual route
                success: function(data) {
                    $('#name1').val(data.roleName);
                },
                error: function() {
                    alert('Failed to fetch role data.');
                }
            });
        });

        $('#roleModal').on('hidden.bs.modal', function () {
            $('#roleForm').trigger('reset');
            $('#roleForm').attr('action', "{{ route('roles.store') }}");
            $('#saveRoleButton').text('Save');
        });

        $('.delete-role').on('click', function() {
            var roleId = $(this).data('id');
            $('#deleteRoleForm').attr('action', '/roles/' + roleId);
        });
</script>

@endsection
