@extends('layouts.pos.dashboard', ['title' => 'Stocks', 'module' => 'Inventory'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">Leads</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btnNew" data-toggle="modal" data-target="#addEditModel">New Lead</button>
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
                                <form action={{route('pos.inventory.stocks.add')}} method='post' id="addEditForm" enctype="multipart/form-data">
                                  @csrf
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Stock Info</a></li>
                                    <!-- <li><a href="#step2"><span class="number">2</span> Lead Action</a></li> -->
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                    <input class="form-control" id="id" name="id" type="text" hidden>
                                    <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="description">Select Product:</label>
                                              <input type='hidden' name="products" id="products" value=''>
                                              <div  ><table id="productArea"></table>
                                              </div><br>
                                             <input class="form-control" type='text' name="productTyping" id="productTyping" value='' placeholder="Type product name to search">                                                 
                                              <ul class="list-group" id='productList'></ul>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row m-t-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label >Select Vendor:</label>
                                            <input type="hidden" name="vendorId" id="vendorId" >
                                              <input class="form-control" type="text" placeholder="Type vendor name or mobile to search" name="vendor" id="vendor" >
                                              <ul class="list-group" id='vendors'></ul>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                            <p>Vendor: <strong id='vendorName'></strong><p>
                                              <p>Company: <strong id='companyName'></strong><p>
                                            </div>
                                          </div>

                                        </div>



                                        <div class="row">
                                          <!-- <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="nextCallingDate">Next Calling Date:</label>
                                              @php 
                                              $date = strtotime("+1 day", strtotime("now"));
                                              $date= date("Y-m-d", $date);
                                              @endphp
                                              <input type="date" class="form-control"  id="nextCallingDate" name="nextCallingDate" value="{{$date}}">
                                            </div>
                                          </div> -->
                                         
                                        </div>
                                    </div>
                                    <!-- <div class="step-tab-panel" id="step2">
                                      <div class="row">
                                      <div class="col-md-3">
                                          <div class="form-group">
                                          <label>Type of Comment</label><br>
                                          <input type="radio" id="customerType" name="commentType" value=0 >
                                          <label for="customerType">Customer</label><br>
                                          <input type="radio" id="userType" name="commentType" value=1 >
                                          <label for="userType">User</label><br>                                                                    
                                          </div>
                                        </div>
                                          <div class="col-md-9">
                                            <div class="form-group">
                                              <label for="comment">Comment:</label>
                                              <textarea class="form-control" type="text" id="comment" name="comment" ></textarea>
                                            </div>
                                          </div>
                                        </div>
                                      <div class="row m-t-2">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="nextCallingDate">Status:</label>
                                              <select class="form-control"  id="status" name="status" >
                                                <option value=1 >Hot</option>
                                                <option value=2 >Mild</option>
                                                <option value=3 >Cold</option>
                                                <option value=4 >Sold</option>
                                                <option value=5 >Dead</option>
                                                <select>
                                            </div>
                                          </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="userAssigned">Assign Lead to:</label>
                                                <input type="hidden" class="form-control"  id="userAssigned" name="userAssigned" >

                                                <input class="form-control" type="text" placeholder="Type user name to search" name="user" id="user">
                                                <ul class="list-group" id='users'></ul>

                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="nextCallingDate">Next Calling Date:</label>
                                              @php 
                                              $date = strtotime("+1 day", strtotime("now"));
                                              $date= date("Y-m-d", $date);
                                              @endphp
                                              <input type="date" class="form-control"  id="nextCallingDateHistory" name="nextCallingDate" value="{{$date}}" disabled>
                                            </div>
                                          </div>
                                      </div>
                                    </div> -->
                                  </div>
                                  <div class="step-footer">
                                    <button data-direction="prev" class="btn btn-light">Previous</button>
                                    <button data-direction="next" class="btn btn-primary">Next</button>
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
                            <th>Sr.#</th>
                            <th>Stock ID</th>
                            <th>Product ID</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Batch</th>
                            <th>Date</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>



                <div class="modal fade" id="leadHistoryModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lead History</h5>
                                <button type="button" class="close" data-dismiss="modal" id="closeModal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-light fa-close"></i></span>
                                </button>
                            </div>
                            <div class="modal-body" id="demo">
                               
                          
                        

                                  <div class="step-content">
                                    Lead ID: <b><span id="leadId"></span></b>
                                    <!-- <div class="step-tab-panel" id="step1"> -->
                                    
                                                      <!-- <div class="table-responsive"> -->
                                                        <table id="leadHistoryDatatable" class="table table-bordered table-hover table-sm">

                                                          <thead>
                                                            <tr>
                                                              <th>Sr.#</th>
                                                              <th>ID</th>
                                                              <th>Comment</th>
                                                              <th>Assigned User</th>
                                                              <th>Comment Type</th>
                                                              <th>Status</th>
                                                              <th>Next Calling Date</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody id="tbodyHistory">
                                                            
                                                          </tbody>
                                                          </table>

                                                      <!-- </div> -->
                                    
 
                                    <!-- </div> -->
                    

                                 
                                </div>
                              
                            </div>  
                        </div>
                    </div>
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
                ajax: "{{ route('pos.inventory.stocks.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'lead_id', name: 'lead_id'},
                    {data: 'personal_info', name: 'personal_info'},
                    {data: 'contact_info', name: 'contact_info'},
                    {data: 'description', name: 'description'},
                    {data: 'nextCallingDate', name: 'nextCallingDate'},
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
                url: "{{ route('pos.inventory.stocks.add') }}",
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
                url: "{{ route('pos.inventory.stocks.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#id').val(response.lead.id);    
                    $('#source').val(response.lead.source_id);        
                    $("#productArea").html(response.lead.product_ids);           
                    $('#description').val(response.lead.description);  
                    $('#fullname').val(response.customer.full_name);
                    $('#mobile').val(response.customer.mobile);
                    $('#email').val(response.customer.email);
                    $('#location').val(response.customer.location);  

                    $("#addEditForm").attr('action', "{{ route('pos.inventory.stocks.update')}}"); 
                    $('#btnSubmit').html("Update");
                    $('#step2').prop('disabled',true);
                    $('#fullname').prop('disabled',true);
                    $('#mobile').prop('disabled',true);
                    $('#email').prop('disabled',true);
                    $('#location').prop('disabled',true);            
                    $('#nextCallingDate').prop('disabled',true);
                    $('#source').prop('disabled',true);
                    $('#productTyping').prop('disabled',true);
                    $('#description').prop('disabled',true);

                    $('#nextCallingDateHistory').prop('disabled',false);
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
                    url: "{{ route('pos.crm.customers.delete') }}",
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
          $("#addEditForm").attr('action', "{{ route('pos.inventory.stocks.add')}}");
          $('input').val('');
          $('input').prop('disabled',false);
          $('textarea').prop('disabled',false);
          $('select').prop('disabled',false);
          $('#nextCallingDateHistory').prop('disabled',true);
          $('textarea').val('');
          $('#productArea').html('');
        } );


          $("#vendor").keyup(function(){
            if($('#vendor').val().length==0)$('#vendors').html('');
            else
            $.ajax({

              type:'GET',
              url: "{{ route('pos.inventory.stocks.getVendorsSearch') }}",
              data: {'vendor':$('#vendor').val()},
              dataType:'JSON',
              success: function(response){

                console.log(response);

                $("#vendors").html(response);
              }
            }); 
        });

        $("#productTyping").keyup(function(){
            if($('#productTyping').val().length==0)$('#productList').html('');
            else
            $.ajax({

              type:'GET',
              url: "{{ route('pos.crm.leads.getProductsSearch') }}",
              data: {'product':$('#productTyping').val()},
              dataType:'JSON',
              success: function(response){

                console.log(response);

                $("#productList").html(response);
              }
            }); 
        });

        function getVendorDetails(id, name, companyName)
        {
            $('#vendorId').val(id);
            $('#vendorName').html(name);
            $('#companyName').html(companyName);
            $(".list-group").html('');
        $("#vendor").val('');
        }

        function addProduct(id,productName){
         
          if(!$("#products").val().includes('-'+id+'-'))
          {
            $("#products").val($("#products").val()+'-'+id.toString()+'-');

            var str=' <tr><td>'.productName.'</td><td><input class="form-control " type="text" name="price-'+id+'" id="price-'+id+'" placeholder="Fill Price"></td>';
            str+='<td> <input class="form-control  " type="text" name="quantity-'+id+'" id="quantity-'+id+'" placeholder="Fill Qunatity"> </td><td><i class="fa fa-trash" onclick="removeProduct('+id+')"></i></td></tr>';
   
          $("#productArea").append(str);  
          }
          $(".list-group").html('');
        $("#productTyping").val('');
        }
        function removeProduct(id){
          document.getElementById('pShow*'+id).remove();
          let str=$("#products").val();
          str=str.replace("-"+id+"-", "");
          $("#products").val(str);
        }
        function selectUser(id){
          $("#userAssigned").val(id);
        }
        $("#nextCallingDate").on('change',function(){
          $("#nextCallingDateHistory").val($("#nextCallingDate").val());
        });
        
    </script>
@endsection