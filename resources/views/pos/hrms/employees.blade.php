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
                                              <input class="form-control" type="text">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="lastName1">Last Name:</label>
                                              <input class="form-control" type="text">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="firstName1">Email Address:</label>
                                              <input class="form-control" type="text">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="lastName1">Phone Number:</label>
                                              <input class="form-control" type="text">
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
                                              <input class="form-control" id="dob" type="date">
                                            </div>
                                          </div>
                                        </div>
                                      
                                    </div>
                                    <div class="step-tab-panel" id="step2">
                                      <div class="row m-t-2">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="jobTitle1">Job Title :</label>
                                            <input class="form-control" id="jobTitle1" type="text">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="videoUrl1">Company Name :</label>
                                            <input class="form-control" id="videoUrl1" type="text">
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="shortDescription1">Job Description :</label>
                                            <textarea name="shortDescription" id="shortDescription1" rows="6" class="form-control"></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="step-tab-panel" id="step3">
                                      <div class="row m-t-2">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="int1">Interview For :</label>
                                            <input class="form-control" id="int1" type="text">
                                          </div>
                                          <div class="form-group">
                                            <label for="intType1">Interview Type :</label>
                                            <select class="custom-select form-control" id="intType1" data-placeholder="Type to search cities" name="intType1">
                                              <option value="Banquet">Normal</option>
                                              <option value="Fund Raiser">Difficult</option>
                                              <option value="Dinner Party">Hard</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label for="Location1">Location :</label>
                                            <select class="custom-select form-control" id="Location1" name="location">
                                              <option value="">Select City</option>
                                              <option value="India">India</option>
                                              <option value="USA">USA</option>
                                              <option value="Dubai">Dubai</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="jobTitle2">Interview Date :</label>
                                            <input class="form-control" id="jobTitle2" type="date">
                                          </div>
                                          <div class="form-group">
                                            <label>Requirements :</label>
                                            <div class="c-inputs-stacked">
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">Employee</span> </label>
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">Contract</span> </label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="step-tab-panel" id="step4">
                                      <div class="row m-t-2">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="behName1">Behaviour :</label>
                                            <input class="form-control" id="behName1" type="text">
                                          </div>
                                          <div class="form-group">
                                            <label for="participants1">Confidance</label>
                                            <input class="form-control" id="participants1" type="text">
                                          </div>
                                          <div class="form-group">
                                            <label for="participants1">Result</label>
                                            <select class="custom-select form-control" id="participants1" name="location">
                                              <option value="">Select Result</option>
                                              <option value="Selected">Selected</option>
                                              <option value="Rejected">Rejected</option>
                                              <option value="Call Second-time">Call Second-time</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="decisions1">Comments</label>
                                            <textarea name="decisions" id="decisions1" rows="4" class="form-control"></textarea>
                                          </div>
                                          <div class="form-group">
                                            <label>Rate Interviwer :</label>
                                            <div class="c-inputs-stacked">
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">1 star</span> </label>
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">2 star</span> </label>
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">3 star</span> </label>
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">4 star</span> </label>
                                              <label class="inline custom-control custom-checkbox block">
                                                <input class="custom-control-input" type="checkbox">
                                                <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">5 star</span> </label>
                                            </div>
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
                alert('Wizard Completed');
            }
        });
    </script>
@endsection