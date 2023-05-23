@extends('layouts.pos.dashboard', ['title' => 'Products', 'module' => 'Inventory'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">Products</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btnNew" data-toggle="modal" data-target="#addEditModel">New Product</button>
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
                                <form action={{route('pos.inventory.products.add')}} method='post' id="addEditForm" enctype="multipart/form-data">
                                  @csrf
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Product Info</a></li>
                                    <li><a href="#step2"><span class="number">2</span> Specifications</a></li>
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                     <input class="form-control" id="id" name="id" type="text" hidden>
                                        <div class="row m-t-2">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="productName">Product Name:</label>
                                              <input class="form-control" type="text" id="productName" placeholder="name" name="productName" required>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="productCategory">Category:</label>
                                              <select class="form-control" type="text" id="productCategory" placeholder="name" name="productCategory" required>
                                              <option>Select Category</option>    
                                              @foreach($categories as $category)
                                                <option value={{$category->id}}>{{$category->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="productQuantity">Quantity:</label>
                                              <input class="form-control" type="text" id="productQuantity" placeholder="Quantity" name="productQuantity" required>
                                            </div>
                                          </div>                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="productName">Price:</label>
                                              <input class="form-control" type="text" id="productPrice" placeholder="Price" name="productPrice" required>
                                            </div>
                                          </div>                         
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="isFeatured">Featured:</label>
                                              <select class="form-control" name="isFeatured" id="isFeatured" required>
                                                <option value=0>No</option>  
                                                <option value=1>Yes</option>
                                            </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="status">Status</label>
                                              <select class="form-control" name="status" id="status" required>
                                                <option value=1>Yes</option>
                                                <option value=0>No</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="tags">Tags</label>
                                              <textarea class="form-control" placeholder="Please fill comma separated keywords" name="tags" id="tags"></textarea>
                                            </div>
                                          </div>

                                        </div>
                                    </div>
                                    <div class="step-tab-panel" id="step2" >
                                      <div class="row m-t-2" id='specForm'>
                                        <!-- <div class="col-md-6" >
                                          <div class="form-group" >
                                                                                          
                                          </div>
                                        </div> -->

                                      </div>
                                    </div>

                                  </div>
                                  <div class="step-footer">
                                    <button type='submit' id='btnSubmit' data-direction="finish" class="btn btn-primary">Submit</button>
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
                            <th>Sr. #</th>
                            <th>SKU</th>
                            <th>product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Specifications</th>
                            <th>Quantity</th>
                            <th>Tags</th>
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
                ajax: "{{ route('pos.inventory.products.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sku', name: 'sku'},
                    {data: 'productName', name: 'productName'},
                    {data: 'categoryId', name: 'categoryId'},
                    {data: 'price', name: 'price'},
                    {data: 'specifications', name: 'specifications'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'tags', name: 'tags'},
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
                url: "{{ route('pos.inventory.products.add') }}",
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
                url: "{{ route('pos.inventory.products.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#id').val(response.id);                  
                    $('#productName').val(response.name);
                    $('#isActive').val(response.isActive);
                    $('#tags').val(response.tags);

                    $("#addEditForm").attr('action', "{{ route('pos.inventory.products.update')}}"); 
                    $('#btnSubmit').html("Update");           
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
                    url: "{{ route('pos.inventory.products.delete') }}",
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
        $( "#btnSubmit" ).on( "click", function() {
          $( "#addEditForm" ).trigger( "submit" );
        } );
        $( "#btnNew" ).on( "click", function() {
          $('#btnSubmit').html("submit");
          $("#addEditForm").attr('action', "{{ route('pos.inventory.products.add')}}");
          $("#addEditForm")[0].reset();
        } );


        $("#addInput").on("click",function(){
              var count=parseInt($("#countInputs").val())+1;
                $("#countInputs").val(count);
                var str="<div class='row'>";
                str+= "<div class='col-md-4'>Name "+count+":<input class='form-control'  type='text' name='inputName-"+count+"'></input></div>";
                str+= "<div class='col-md-3'>Type of input:<select class='form-control' id='inputType-"+count+"' onchange='typeChange("+count+")' name='inputType-"+count+"'>";
                str+= "<option value='text'>Text</option> <option value='dropdown'>Dropdown</option> <option value='boolean'>Boolean</option> </select> </div>";    
                str+= "<div class='col-md-3'>Status:<select class='form-control' name='inputStatus-"+count+"'>";  
                str+= "<option value='1'>Active</option> <option value='0'>Inactive</option> </select> </div></div>";    
                str+= "<div class='row'><div class='col-md-12' id='div"+count+"' >V                                                                                                                                                                                                                                                                                                                                                                                       alue: <input  class='form-control' placeholder='Please fill default value' type='text' name='inputValue-"+count+"'></input></div></div><br><br>";
                $("#step2").append(str);
        });

        function typeChange(count)
        {
          str="";
          if($("#inputType-"+count.toString()).val()==="dropdown")
          {
            str="Value: <input  class='form-control'  type='text' name='inputValue-"+count+"' placeholder='Please fill options separated by comma'></input></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          if($("#inputType-"+count.toString()).val()==="boolean")
          {
            str="Choose default value:<select class='form-control' name='inputValue-"+count+"'> <option value='1'>Yes</option> <option value='0'>No</option></select></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          if($("#inputType-"+count.toString()).val()==="text")
          {
            str="Value: <input  class='form-control'  type='text' name='inputValue-"+count+"' placeholder='Please fill default value'></input></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          
        }
        $('#productCategory').on('change', function(e) { console.log($('#productCategory').val());
            $.ajax({
                data: {'id':$('#productCategory').val()},
                url: "{{ route('pos.inventory.products.getSpecForm') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#specForm').html(response);           
                }
            });
        });
    </script>

@endsection