@extends('layouts.pos.dashboard', ['title' => 'Positions', 'module' => 'HRMS'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">Job Positions</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEditModel">New Position</button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addEditModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" id="closeModal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-light fa-close"></i></span>
                                </button>
                            </div>
                            <form action="{{ route('pos.hrms.positions.add')}}" method="POST" id="addEditForm">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div id="error" class="col-md-12"></div>
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <label>Positions</label>
                                                <input class="form-control" id="position" name="position" type="text" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <label>Max Employees</label>
                                                <input class="form-control" id="max_pos" name="max_pos" type="text" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <label>Details <span class="optional">(Optional)</span></label>
                                                <textarea class="form-control" id="details" name="details" type="text"></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ID #</th>
                            <th>Positions</th>
                            <th>Max Employees</th>
                            <th>Details</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" type="text/css" />
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            loadDataTable();
        });
        public function loadDataTable () {
            var table = $('#datatable').DataTable({
                paging: true,
                retrieve: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('pos.hrms.positions.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'position', name: 'position'},
                    {data: 'max_pos', name: 'max_pos'},
                    {data: 'details', name: 'details'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        };
        $('#addEditForm').on('submit', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $("#saveBtn").html('<i class="fa-light fa-loader rotate"></i>');
            $.ajax({
                data: $('#addEditForm').serialize(),
                url: "{{ route('pos.hrms.positions.add') }}",
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    $('#addForm').trigger('reset');
                    $('#error').empty();
                    $('#closeModal').trigger('click');
                    loadDataTable();
                },
                error: function(data) {
                    if(data.error = 422) {
                        $('#error').html('<p class="alert alert-danger">'+data.responseJSON.message+'</p>');
                        console.log(data.responseJSON.message);
                    }
                    $('#saveBtn').html('Save Changes');
                }
            });
        });
    </script>
@endsection