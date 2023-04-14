@extends('layouts.pos.dashboard', ['title' => 'Positions', 'module' => 'HRMS'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">All Employees</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEditModel">New Employee</button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addEditModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" id="closeModal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-light fa-close"></i></span>
                                </button>
                            </div>
                            <div class="modal-body" id="demo">
                                <form>
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Personal Info</a></li>
                                    <li><a href="#step2"><span class="number">2</span> Contact Info</a></li>
                                    <li><a href="#step3"><span class="number">3</span> Job Details</a></li>
                                    <li><a href="#step4"><span class="number">4</span> POS Access</a></li>
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                      
                                        <div class="row m-t-2">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="firstName1">First Name:</label>
                                              <input class="form-control" type="text" placeholder="First Name" name="firstname">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="lastName1">Last Name:</label>
                                              <input class="form-control" type="text" placeholder="Last Name" name="lastname">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="firstName1">Email Address:</label>
                                              <input class="form-control" type="text" placeholder="Email" name="email">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="lastName1">Phone Number:</label>
                                              <input class="form-control" type="text" placeholder="Mobile" name="mobile">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="gender">Gender :</label>
                                              <select class="custom-select form-control" id="gender" name="gender">
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Others">Others</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="dob">Date of Birth :</label>
                                              <input class="form-control" id="dob" type="date" name="dob">
                                            </div>
                                          </div>
                                        </div>
                                      
                                    </div>
                                    <div class="step-tab-panel" id="step2">
                                      <div class="row m-t-2">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="address">Address</label>
                                            <input class="form-control" id="address" type="text" name="address" placeholder="Street Address">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="pincode">Pincode</label>
                                            <input class="form-control" id="videoUrl1" type="text" name="pincode" placeholder="Pincode">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="city">City / State</label>
                                            <input class="form-control" id="city" type="text" name="city" placeholder="city">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="aadhar">Aadhar</label>
                                            <input class="form-control" id="videoUrl1" type="text" name="aadhar" placeholder="0000 0000 0000">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="emergency">Emergency Contact</label>
                                            <input class="form-control" id="city" type="text" name="emergency" placeholder="Emergency number">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="step-tab-panel" id="step3">
                                      <div class="row m-t-2">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="position">Job Title :</label>
                                            <select class="custom-select form-control" id="position" name="position">
                                            @if($positions)
                                              @foreach($positions as $position)
                                              <option value="{{ $position->position }}">{{ $position->position }}</option>
                                              @endforeach
                                            @endif
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="salary">Salary</label>
                                            <input class="form-control" id="salary" type="text" name="salary">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="doj">Joining date</label>
                                            <input class="form-control" id="doj" type="date" name="doj">
                                          </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="in_time">In-time</label>
                                            <input class="form-control" id="in_time" type="time" name="in_time">
                                          </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="out_time">Out-time</label>
                                            <input class="form-control" id="out_time" type="time" name="out_time">
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="photo">Employee Photo</label>
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" id="customFile">
                                              <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="step-tab-panel" id="step4">
                                      <div class="row m-t-2">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="behName1">Username</label>
                                            <input class="form-control" id="behName1" type="text">
                                          </div>
                                          <div class="form-group">
                                            <label for="participants1">Password</label>
                                            <input class="form-control" id="participants1" type="text">
                                          </div>
                                          <div class="form-group">
                                            <label for="participants1">Confirm password</label>
                                            <input class="form-control" id="participants1" type="text">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="permission">Comments</label>
                                            <select name="permission" id="permission" rows="6" class="form-control" multiple></select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="step-footer">
                                    <button data-direction="prev" class="btn btn-light">Previous</button>
                                    <button data-direction="next" class="btn btn-primary">Next</button>
                                    <button data-direction="finish" class="btn btn-primary">Submit</button>
                                  </div>
                                </div>
                                <form>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>ID #</th>
                            <th>Photo</th>
                            <th>Personal Info</th>
                            <th>Contact Info</th>
                            <th>Job Details</th>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/formwizard/jquery-steps.css') }}">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <!-- form wizard --> 
    <script src="{{ asset('assets/plugins/formwizard/jquery-steps.js') }}"></script> 
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                paging: true,
                retrieve: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pos.hrms.employees.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'first_name', name: 'position'},
                    {data: 'max_pos', name: 'max_pos'},
                    {data: 'details', name: 'details'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
            
        $('#addBtn').on('click', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $(".save-btn").html('<i class="fa-light fa-loader rotate"></i>');
            $.ajax({
                data: $('#addEditForm').serialize(),
                url: "{{ route('pos.hrms.positions.add') }}",
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    $('#addEditForm')[0].reset();
                    $('#error').empty();
                    $('#closeModal').trigger('click');
                    $('.save-btn').html('Save');
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(data) {
                    if(data.error = 422) {
                        $('#error').html('<p class="alert alert-danger">'+data.responseJSON.message+'</p>');
                        console.log(data.responseJSON.message);
                    }
                    $('.save-btn').html('Save');
                }
            });
        });
        function showData(id) {
            $.ajax({
                data: {'id':id},
                url: "{{ route('pos.hrms.positions.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#position').val(response.position);
                    $('#max_pos').val(response.max_pos);
                    $('#details').val(response.details);
                    $('#id').val(response.id);
                }
            });
        }
        function delData(id) {
            if(confirm('Are you sure you want to delete?') == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('pos.hrms.positions.delete') }}",
                    data: {'id': id},
                    dataType: 'JSON',
                    success: function(response) {
                        $('#datatable').DataTable().ajax.reload();
                    }
                });
            }
        }

        $('#demo').steps({
            onFinish: function () {

            }
        });
    </script>
@endsection