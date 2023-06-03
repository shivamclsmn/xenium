@extends('layouts.pos.dashboard', ['title' => 'Vendors', 'module' => 'Inventory'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-4 text-md-left text-center">Vendors</h2>
                    <div class="mb-4 col-md-4 " id="error"></div>
                    <div class="mb-4 col-md-4 text-right">
                        <button class="btn btn-primary btn-sm" id="btnNew" data-toggle="modal" data-target="#addEditModel">New vendor</button>
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
                                <form action={{route('pos.inventory.vendors.add')}} method='post' id="addEditForm" enctype="multipart/form-data">
                                  @csrf
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Vendor Info</a></li>
                                    <!-- <li><a href="#step2"><span class="number">2</span> Specifications</a></li> -->
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                     <input class="form-control" id="id" name="id" type="text" hidden>
                                        <div class="row m-t-2">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="vendorName">Vendor Name:</label>
                                              <input class="form-control" type="text" id="vendorName" placeholder="name" name="vendorName" required>
                                              <input class="form-control" type="hidden" id="vendorId" placeholder="name" name="vendorId">
                                            </div>
                                          </div>
                                          <!-- <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="vendorCategory">Category:</label>
                                              <select class="form-control" type="text" onchange='getSpecForm()' id="vendorCategory" placeholder="name" name="vendorCategory" required>
                                              <option>Select Category</option>    
                                              @foreach($categories as $category)
                                                <option value={{$category->id}}>{{$category->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div> -->
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="vendorQuantity">Company name:</label>
                                              <input class="form-control" type="text" id="companyName" placeholder="Company" name="companyName" required>
                                            </div>
                                          </div>                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="mobile">Mobile:</label>
                                              <input class="form-control" type="text" id="mobile" placeholder="mobile" name="mobile" required>
                                            </div>
                                          </div>                         
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="isFeatured">Email:</label>
                                              <input class="form-control" type="text" class="form-control" name="email" id="email" required>
                                         
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="address">Address:</label>
                                              <input class="form-control" type="text" class="form-control" name="address" id="address" required>
                                         
                                            </div>
                                          </div>
                                        </div>
                                    
                                    </div>
   

                                  </div>
                                  <div class="step-footer">
                                    <button type='submit' id='btnSubmit' data-direction="finish" class="btn btn-primary">Submit</button>
                                  </div>
                                </div>
                              </form>
                            </div>  
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>Sr. #</th>
                            <th>Vendor Name</th>
                            <th>Company Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dropify.min.css') }}" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/plugins/formwizard/jquery-steps.css') }}">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/dropify/dropify.min.js')}}"></script>
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
                ajax: "{{ route('pos.inventory.vendors.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'companyName', name: 'companyName'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'email', name: 'email'},
                    {data: 'address', name: 'address'},
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
                url: "{{ route('pos.inventory.vendors.add') }}",
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
                url: "{{ route('pos.inventory.vendors.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#id').val(response.id);                  
                    $('#vendorName').val(response.name);
                    $('#companyName').val(response.companyName);
                    $('#mobile').val(response.mobile);
                    $('#email').val(response.email);
                    $('#address').val(response.address);
                    $("#addEditForm").attr('action', "{{ route('pos.inventory.vendors.update')}}"); 
                    $('#btnSubmit').html("Update");  
                    getSpecForm();         
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
                    url: "{{ route('pos.inventory.vendors.delete') }}",
                    data: {'id': id},
                    dataType: 'JSON',
                    success: function(response) {
                        $('#datatable').DataTable().ajax.reload();
                    },
                    error: function(response){
                  if(response.error = 500) {
                        $('#error').html('<p class="alert alert-danger">Please deleted all images vendor before. </p>');
                        console.log(response.responseJSON.message);
                        $("#error").fadeTo(5500, 0.0);
                    }
                }
                });
            }
        }

        $('#demo').steps({
            onFinish: function () {

            }
        });

        $( "#btnSubmit" ).on( "click", function() {
          $( "#addEditForm" ).trigger( "submit" );
        } );
        $( "#btnNew" ).on( "click", function() {
          $('#btnSubmit').html("submit");
          $("#addEditForm").attr('action', "{{ route('pos.inventory.vendors.add')}}");
          $("#addEditForm")[0].reset();
          $("#vendorId").val('');
        } );

    </script>

@endsection