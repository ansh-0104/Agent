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
    .btn-primary .new {
        --bs-btn-color: #fff !important;
        --bs-btn-bg: #1c3d6d !important;
        --bs-btn-border-color: #1c3d6d !important;
        --bs-btn-hover-color: #fff !important;
        --bs-btn-hover-bg: #0952bc !important;
        --bs-btn-hover-border-color: #0952bc !important;
        --bs-btn-focus-shadow-rgb: 49, 132, 253 !important;
        --bs-btn-active-color: #fff !important;
        --bs-btn-active-bg: #0952bc !important;
        --bs-btn-active-border-color: #0a53be !important;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
        --bs-btn-disabled-color: #fff !important;
        --bs-btn-disabled-bg: #0d6efd !important;
        --bs-btn-disabled-border-color: #0d6efd !important;
    }

    .fas {
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

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
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
    <h2>Imports</h2>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Progress</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($uploads as $upload)
            <tr>
                <td>{{ $upload->file }}</td>
                <td>
                    <div class="progress-container">
                        <progress value="{{ $upload->progress }}" max="100"></progress>
                        <span>{{ number_format($upload->progress, 2) }}%</span>
                    </div>
                </td>
                <td>
                    @if($upload->progress==100)
                    <a class="  delete-role" data-toggle="modal" data-target="#deleteRoleModal" data-id="{{ $upload->id }}">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Delete File</h5>
                <button type="button" class="close btn-primary new" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this file?</p>
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
    $('.delete-role').on('click', function() {
        var roleId = $(this).data('id');
        $('#deleteRoleForm').attr('action', '/import/' + roleId);
    });
</script>

@endsection