@extends('layouts.pos.dashboard', ['title' => 'Orders', 'module' => 'Sales'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">Orders</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btnNew" data-toggle="modal" data-target="#addEditModel">New Order</button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addEditModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" id="closeModal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-light fa-close"></i></span>
                                </button>
                            </div>
                            <div class="modal-body" id="demo">
                                <form action={{route('pos.sales.orders.add')}} method='post' id="addEditForm" enctype="multipart/form-data">
                                  @csrf
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Order Info</a></li>
                                    <li><a href="#step2"><span class="number">2</span> Address Info</a></li>
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                    <input class="form-control" id="id" name="id" type="text" hidden>

                                        <div class="row m-t-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="lastName1">Phone Number:</label>
                                              <input type="hidden" name="customerId" id="customerId" required>
                                              <input class="form-control" type="text" placeholder="Mobile" name="mobile" id="mobile" pattern="[0-9]{10}" required>
                                              <ul class="list-group" id='customers'></ul>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="firstName1">Email Address:</label>
                                              <input class="form-control" type="text" placeholder="Email" name="email" id="email">
                                            </div>
                                          </div>

                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="firstName1">Full Name:</label>
                                              <input class="form-control" type="text" id="fullname" placeholder="Full Name" name="fullname" required>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="shipping">Shipping:</label><br>
                                              <input  type="checkbox"  id="shipping" name="shipping" value=1>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="description">Add Items:</label>
                                              <input type='hidden' name="products" id="products" value=''>
                                              <div  >
                                                    <input type='hidden' name="entriesCount" id="entriesCount" value="1" >


                                                    <input type='hidden' name="totalAmount" id="totalAmount"  >
                                                    <table class="table table-bordered table-hover table-sm">

                                                        <thead>
                                                          <tr>
                                                          
                                                            <th>Item</th>
                                                            <th>Price/Unit</th>
                                                            <th>Quantity</th>
                                                            <th>Total Price</th>
                                                            <td></td>
                                                          </tr>
                                                        </thead>
                                                        <tbody id="productArea">
                                                        </tbody>
                                                        <tfoot id="tFoot">
                                                            <tr>
                                                          
                                                              <td></td>
                                                              <td></td>
                                                              <td>Discount%</td>
                                                              <td id="discountPercentShow" class='price'>
                                                              <input type='text' class="w-25 form-control" name="discountPercent" id="discountPercent" onkeyup="updateTotalPrice()" pattern="[0-9]">
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                        
                                                              <td></td>
                                                              <td></td>
                                                              <td>Discount Amount</td>
                                                              <td id="discountAmountShow" class='price'>
                                                              <input type='text' class="w-25 form-control" name="discountAmount" id="discountAmount"  onkeyup="updateTotalPrice()" pattern="[0-9]">
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                           
                                                              <td></td>
                                                              <td></td>
                                                              <td>Shipping price</td>
                                                              <td id="shippingPrice" class='price'>0</td>
                                                            </tr>
`                                                           <tr>
                                                          
                                                              <td></td>
                                                              <td></td>
                                                              <td>Total Amount</td>
                                                              <td><strong id="totalPrice">0</strong></td>
                                                            </tr>
                                                        </tfoot>
                                                        </table>
                                              </div><br>
                                             <input class="form-control" type='text' name="productTyping" id="productTyping" value='' placeholder="Type product name to search">                                                 
                                              <ul class="list-group" id='productList'></ul>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="description">Remark:</label>
                                              <textarea class="form-control" type="text" id="description" name="description" ></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="nextCallingDate">Next Calling Date:</label>
                                              @php 
                                              $date = strtotime("+1 day", strtotime("now"));
                                              $date= date("Y-m-d", $date);
                                              @endphp
                                              <input type="date" class="form-control"  id="nextCallingDate" name="nextCallingDate" value="{{$date}}">
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <label for="nextCallingDate">Lead Source:</label>
                                              <select class="form-control"  id="source" name="source" >
                                                <option value=1 >Reference</option>
                                                <option value=2 >Website</option>
                                                <option value=2 >Facebook</option>
                                                <option value=3 >Youtube</option>
                                                <select>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="step-tab-panel" id="step2">
                                      <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="address">Address</label>
                                            <input class="form-control" id="address" type="text" id="address" name="address" placeholder="Street Address">
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="city">City / State</label>
                                            <input class="form-control" id="city" type="text" name="city" placeholder="City">
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="pincode">Pincode</label>
                                            <input class="form-control" id="videoUrl1" type="text" id="pincode" name="pincode" placeholder="Pincode">
                                          </div>
                                        </div>
                                        </div>
                                      <div class="row m-t-2">




                                      </div>
                                    </div>
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
                            <th>Lead ID</th>
                            <th>Personal Info</th>
                            <th>Contact Info</th>
                            <th>Description</th>
                            <th>Next Calling Date</th>
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
                ajax: "{{ route('pos.sales.orders.table') }}",
                columns: [
                    {data: 'DT_rowNum', name: 'DT_rowNum'},
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
                url: "{{ route('pos.sales.orders.add') }}",
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
                url: "{{ route('pos.sales.orders.show') }}",
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

                    $("#addEditForm").attr('action', "{{ route('pos.sales.orders.update')}}"); 
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
          $("#addEditForm").attr('action', "{{ route('pos.sales.orders.add')}}");
          $('input').val('');

          $('#entriesCount').val(0);
          $('#discountPercent').val(0);
          $('#discountAmount').val(0);

          $('input').prop('disabled',false);
          $('textarea').prop('disabled',false);
          $('select').prop('disabled',false);
          $('#nextCallingDateHistory').prop('disabled',true);
          $('textarea').val('');
          $('#productArea').html('');
          //$("#tFoot").hide();
        } );

          $("#mobile").keyup(function(){
            if($('#mobile').val().length==0)$('#customers').html('');
            else
            $.ajax({

              type:'GET',
              url: "{{ route('pos.crm.leads.getCustomersSearch') }}",
              data: {'mobile':$('#mobile').val()},
              dataType:'JSON',
              success: function(response){

                console.log(response);

                $("#customers").html(response);
              }
            }); 
        });

        $("#productTyping").keyup(function(){
            if($('#productTyping').val().length==0)$('#productList').html('');
            else
            $.ajax({

              type:'GET',
              url: "{{ route('pos.sales.orders.getProductsSearch') }}",
              data: {'product':$('#productTyping').val()},
              dataType:'JSON',
              success: function(response){

                console.log(response);

                $("#productList").html(response);
              }
            }); 
        });

        function getCustomerDetails(id){
          $.ajax({
                data: {'id':id},
                url: "{{ route('pos.crm.customers.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#customerId').val(response.id);                  
                    $('#fullname').val(response.full_name);
                    $('#mobile').val(response.mobile);
                    $('#email').val(response.email);
                    $('#address').val(response.address);

                    $("#fullname").attr('disabled',true); 
                    $("#email").attr('disabled',true); 
                    $("#location").attr('disabled',true); 

                    (response.isDealer)?  $('#dealer').prop('checked',true): $('#customer').prop('checked',true);
                    $("#customers").html('');         
                }
              });
        }

        function addProduct(itemId,itemName,itemPrice){
         let itemNotExist=true;
          $('.itemQuantity').each(function () {
              if('item-'+itemId==this.name){
              itemNotExist=false;
              }
          });

         if(itemNotExist){
          let rowNum=parseInt($("#entriesCount").val())+1;

           $("#products").val($("#products").val()+'-'+id.toString()+'-');
            let str='<tr class="item" id="row'+rowNum+'">';
            str+='<td>'+itemName+'</td>';
            str+='<td id="price'+itemId+'">'+itemPrice+'</td>';
            str+='<td><input type="text" class="w-25 form-control itemQuantity" name="item-'+itemId+'" value="1" id="Quantity'+itemId+'" onkeyup="updateTotalPrice()" required></td>';
            str+='<td>'+itemPrice+'</td>';
            str+='<td onclick="removeProduct('+rowNum+')"><i class="fa-light fa-trash"></i></td>';
            str+='</tr>';

           $("#productArea").append(str);
           $('#entriesCount').val(rowNum);  

           updateTotalPrice();
         }
           // $("#tFoot").show();
       }
       function removeProduct(num){
         document.getElementById('row'+num).remove();
         
         $('#entriesCount').val(parseInt($('#entriesCount').val())-1); 

         updateTotalPrice()
       }
       $("#shipping").change(function() {
          if(this.checked) {
            $('#shippingPrice').html(400);
          }
          else{
            $('#shippingPrice').html(0);
          }
          updateTotalPrice()
        });

      function updateTotalPrice(){
        let sum=0.0;

        $('.itemQuantity').each(function () {

          
        //  for(let i=1; i<= $('.item').length; i++)
        {
          let price=0.0;
          let quantity=0.0;
          if ($('#price'+this.name.substring(5)).html()!== ""){
              price=parseFloat($('#price'+this.name.substring(5)).html());
            }
          if (this.value!== ""){
            quantity=parseFloat(this.value);
          }
          sum +=price*quantity;
        }


          });



        let discPercent=0.0;
        let discAmount=0.0;
        if ($('#discountPercent').val()!== "")
        {
          discPercent=(parseFloat($('#discountPercent').val()) * sum)/100;
        }
        if ($('#discountAmount').val()!== "")
        {
          discAmount=parseFloat($('#discountAmount').val());
        }
       
        sum=sum-discPercent-discAmount;

        sum +=parseFloat($('#shippingPrice').html());
          $('#totalPrice').html(sum);
      }

    </script>
@endsection