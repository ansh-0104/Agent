@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .btn-primary {
    --bs-btn-color: #fff;
    --bs-btn-bg: #1c3d6d;
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

element.style {
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
    <h1>User Data</h1>
    <div class="row">
    <div class="col-9">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
        Add User
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importUserModal">
    Import Users
</button>


<a href="{{ route('export.index') }}" class="btn btn-primary">Export Records as CSV</a>
</div>
    </div>
    <hr>
    <div id="table-container" class="table-responsive datatables">
    <table id="userTable" class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>Roles</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Hobbies</th>
                <th>Gender</th>
                <th>Address</th>
                <th>City</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- User data will be loaded dynamically using DataTables AJAX -->
        </tbody>
    </table>
    </div>
    <!-- Button to open the modal -->
   

    <!-- The Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close btn btn-primary" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="addUserForm" action="{{ route('users.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select id="role" name="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone No:</label>
                            <input type="number" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>Gender:</label><br>
                            <label for="gender-male">
                                <input type="radio" id="gender-male" name="gender" value="male"> Male
                            </label>
                            <label for="gender-female">
                                <input type="radio" id="gender-female" name="gender" value="female"> Female
                            </label>
                            <label for="gender-other">
                                <input type="radio" id="gender-other" name="gender" value="other"> Other
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="hobbies">Hobbies:</label>
                            <select id="hobbies" name="hobbies[]" class="form-control" multiple>
                                <option value="reading">Reading</option>
                                <option value="sports">Sports</option>
                                <option value="music">Music</option>
                                <!-- Add more hobby options as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveUser">Save</button>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>

    <div class="modal" id="editUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close btn btn-primary" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="editUserForm" action="{{ route('users.update') }}" method="POST">
                        @csrf
                        <input type="hidden" id="editUserId" name="id">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone No:</label>
                            <input type="number" class="form-control" id="editPhone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="editGender">Gender:</label><br>
                            <label for="gender-male">
                                <input type="radio" id="gender-male" name="gender" value="male"> Male
                            </label>
                            <label for="gender-female">
                                <input type="radio" id="gender-female" name="gender" value="female"> Female
                            </label>
                            <label for="gender-other">
                                <input type="radio" id="gender-other" name="gender" value="other"> Other
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="editHobbies">Hobbies:</label>
                            <select id="editHobbies" name="hobbies[]" class="form-control" multiple>
                                <option value="reading">Reading</option>
                                <option value="sports">Sports</option>
                                <option value="music">Music</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address:</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="editCity">City:</label>
                            <input type="text" class="form-control" id="editCity" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role:</label>
                            <select id="editRole" name="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->

            </div>
        </div>
    </div>


    <div class="modal" id="deleteUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete User</h4>
                <button type="button" class="close btn btn-primary" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" action="{{ route('users.destroy', 0) }}" method="POST">
                    @csrf
                    <input type="hidden" id="deleteUserId" name="id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="importUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Import Users from CSV</h4>
                <button type="button" class="close btn btn-primary" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="importUserForm" action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="csvFile">Select a CSV file:</label>
                        <input type="file" class="form-control-file" id="csvFile" name="csvFile" required>
                    </div>
                    <a href='/download'>Sample File</a>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="importUserForm" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>




</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('users.data') }}", // Define the route to retrieve user data
            columns: [{
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'contact_number',
                    name: 'contact_number'
                },
                {
                    data: 'hobbies',
                    name: 'hobbies'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'city',
                    name: 'city'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
    targets: -1, // Target the last column (Action)
    render: function(data, type, full, meta) {
        return '<a class="edit-user button" data-toggle="modal" data-target="#editUserModal" data-id=' + full.id + '><i class="fas fa-pencil-alt"></i></a> ' +
            '<a href="#" class="delete-user button" data-id="' + full.id + '" data-toggle="modal" data-target="#deleteUserModal"><i class="fas fa-trash"></i></a>';
    }
}],
        });
        $('#addUserModal').on('show.bs.modal', function(e) {
            // Clear the form fields when the modal is opened
            $('#addUserForm')[0].reset();
        });

        $('#userTable').on('click', '.edit-user', function() {
            var userId = $(this).data('id'); // Get the user ID from the data attribute
            var editModal = $(this);
            // Make an AJAX request to fetch the user's data
            $.ajax({
                type: 'GET',
                url: '/get-user/' + userId, // Replace with your actual route
                success: function(data) {
                    // Populate the modal fields with the user data
                    $('#editUserId').val(data.id);
                    $('#editName').val(data.name);
                    $('#editEmail').val(data.email);
                    $('#editPhone').val(data.contact_number);
                    $('#editGender').val(data.gender);
                    $('#editHobbies').val(data.hobbies);
                    $('#editAddress').val(data.address);
                    $('#editCity').val(data.city);
                    $('#editRole').val(data.role);

                    // $('#editUserModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch user data.');
                }
            });
        });

        $('#userTable').on('click', '.delete-user', function() {
                var userId = $(this).data('id');
                $('#deleteUserId').val(userId);
            });


    });
</script>
@endsection