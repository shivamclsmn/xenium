<!DOCTYPE html>
<html>
<head>
    <title>Classmonitor-Invoice</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:200px;
        height:60px;        
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">{{$invoiceId}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">{{str_pad($orderId, 8, "0", STR_PAD_LEFT);}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{{$date}}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
       
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>Classmonitor,</p>
                    <p>Indore,</p>
                    <p>MP, India</p>                    
                    <p>Contact: 62 6204 6204</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p> {{$full_name}}, Customer Id: {{$customerId}}</p>
                    <p>@if(isset($address))Address: {{$address}},@endif</p>
                    <p>@if(isset($city))City: {{$city}},@endif @if(isset($pincode))Pincode: {{$pincode}}@endif</p>                    
                    <p>Contact: {{$mobile}}</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Detail</th>
        </tr>
        <tr>
            <td>{{$paymentMode}}</td>
            <td>@if(isset($shippingCharge))Shipping Applied @else Shipping Not Applied @endif</td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">SKU</th>
            <th class="w-50">Product Name</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Subtotal</th>
        </tr>
{!!$items!!}
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        
                    @if($discountPercent>0) <p>Discount%:</p>@endif
                    @if($discountAmount>0)<p>Discount Fixed:</p>@endif
                    @if(isset($shippingCharge)) <p>Shipping Charge:</p>@endif   
                    <p>Total Payable</p>
                        @if(isset($partPay)) 
                        <p>Due Amount</p>
                        <p>Due Date:</p>
                        <p>Current Payable:</p>
                        @endif
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                    
                    @if($discountPercent>0) <p>{{number_format((float)$discountPercent, 2, '.', '')}}</p>@endif
                    @if($discountAmount>0) <p>{{number_format((float)$discountAmount, 2, '.', '')}}</p>@endif
                    @if(isset($shippingCharge))<p>{{number_format((float)$shippingCharge, 2, '.', '')}}</p>@endif  
                        <p><u>{{number_format((float)$totalAmount, 2, '.', '')}}</u></p>
                        @if(isset($partPay))
                        <p>{{number_format((float)$dueAmount, 2, '.', '')}}</p>
                        <p>{{$nextPayDate}}</p>
                        <p><u>{{number_format((float)$currentPay, 2, '.', '')}}</u></p>
                        @endif
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
    

</div>
</html>