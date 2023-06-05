<?php

namespace App\Http\Controllers\Pos\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\Orders;
use App\Models\Sales\OrderLogs;
use App\Models\User;
use App\Models\Inventory\Products;
use App\Models\Inventory\Stocks;
use App\Models\Sales\OrdersItems;
use App\Models\CRM\Customers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Orders::get();
        $tokenTag=  '<input type="hidden" name="_token" value="'.csrf_token().'">';
        return view('pos.sales.orders', compact('data','tokenTag'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoiceLatest=Orders::orderBy('id','desc')->first();
        if(isset($invoiceLatest->invoiceId))
        {   
            $num='0001';
            if(!strcmp(date("m").date("y"),  substr($invoiceLatest->invoiceId, 0,4)))
            {
                $num=((int)substr($invoiceLatest->invoiceId, 4))+1;
                $num=str_pad($num, 4, "0", STR_PAD_LEFT);
            }
            $data['invoiceId']=date("m").date("y").$num;
        }
        else
        {
            $data['invoiceId']=date("m").date("y").'0001';
        }
        $data['customerId']=$request->input('customerId');
        $data['totalAmount']=$request->input('totalAmount');
        $data['paymentMode']=$request->input('paymentMode');
        $data['discountPercent']=$request->input('discountPercent');
        $data['discountAmount']=$request->input('discountAmount');
        $data['shipping']=$request->input('shipping');
        $data['remark']=$request->input('remark');
        $data['userId'] = Auth::user()->id;
        $data['paymentStatus']=0;
        $data['orderStatus']=1; //1:accepted, 2:dispatch, 3:shipping, 4:delivered, 5:completed 
        $data['dateCreated']= Carbon::now()->toDateTimeString();
        $data['paidAmount']=$request->input('totalAmount');

        if($request->input('paymentPartial'))
        {
            $data['paidAmount']=$request->input('partialAmount');
            $arr['partialAmount']=$request->input('partialAmount');
            $arr['nextPayDate']=$request->input('nextPayDate');
            $arr['dueAmount']=(float)$request->input('totalAmount') - (float)$request->input('partialAmount');

            $data['partialPayDetails']=json_encode($arr);
            $data['paymentStatus']=2; //0:nil, 1:complete, 2:partial
        }
        $dataOI['orderId']=Orders::insertGetId($data);


        $itemIds=[];
        $availability=true;
        $stockOverProductId='';

        foreach($request->input() as $key => $value)
        {
            if(substr($key,0,5)=="item-")
            {
                 array_push($itemIds,substr($key,5));
                 $itemId=substr($key,5);
                 $asp=Stocks::where('productId',$itemId)->sum('quantity');
                 // asp = Available Stock of a Product

                 if((int)$asp <  (int)$value) //$value contains the quantity of requested item
                 {
                    $availability=false;
                 }

            }
        }
        if($availability)
        {

            foreach($itemIds as $itemId)
            {
                     $dataOI['itemId']=$itemId;
                     $dataOI['quantity']=$request->input('item-'.$itemId);

                        if(OrdersItems::insert($dataOI))
                        {
                            //$asp=(int)Stocks::where('productId',$itemId)->sum('quantity');
                            // asp = Available Stock of a Product

                            $stockDecrement=0;
                            $i=0;

                            do{
                                $oasp=Stocks::where('productId',$dataOI['itemId'])
                                ->where('quantity','>',0)->orderBy('id')
                                ->skip($i++)->take(1)->first();
                                        //oasp = Oldest Available Stock of a Product
                                $thisStockQuantity=(int)$oasp->quantity;

                                if($stockDecrement < (int)$dataOI['quantity'])
                                {
                                    $stockDecrement+=$thisStockQuantity;
                                    $thisStockQuantity=0;
                                    
                                }
                                else
                                {
                                    $thisStockQuantity=(int)$dataOI['quantity']-$stockDecrement;
                                    $stockDecrement+=$thisStockQuantity-(int)$dataOI['quantity'];

                                }
                                echo $i.' '.$thisStockQuantity.' '.$stockDecrement; 
                                    Stocks::where('id',$oasp->id)->update(['quantity'=>$thisStockQuantity]);

                            }while($stockDecrement < (int)$dataOI['quantity']);
                            die;
                        }
                                     
            }
        }
        else
        {
            dd('not available');
            return redirect(route('pos.sales.orders'))->with('msg-failed','No Sufficient Stock, Product ID-'.$stockOverProductId);
        }

        $dataLog['itemIds']=json_encode($itemIds);
        $dataLog['amountToPay']=$request->input('totalAmount');
        $dataLog['paidAmount']=$data['paidAmount'];
        $dataLog['orderId']=$dataOI['orderId'];
        $dataLog['actionType']='create';
        $dataLog['time']=$data['dateCreated'];
        $dataLog['discountPercent']=$request->input('discountPercent');
        $dataLog['discountAmount']=$request->input('discountAmount');
        $dataLog['userId'] = Auth::user()->id;
        OrderLogs::insert($dataLog);

        $dataAddr['address']=$request->input('address');
        $dataAddr['pincode']=$request->input('pincode');
        $dataAddr['city']=$request->input('city');

        Customers::where('id',$request->input('customerId'))->update($dataAddr);

        return redirect(route('pos.sales.orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Orders::leftjoin('customers','customers.id','=','orders.customerId')
            ->select('orders.*','customers.id as idCustomer',
            'customers.full_name',
            'customers.mobile',)
            ->orderBy('orders.id','desc')->get();

            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('personal_info', function($row){
                    return $row->full_name;
                })
                ->addColumn('contact_info', function($row){
                    return $row->mobile.'<br>'.$row->email.'</b>';
                })
                ->addColumn('totalAmount', function($row){
                    return $row->totalAmount;
                })
                ->addColumn('dueAmount', function($row){
                    return (float)($row->totalAmount)-(float)($row->paidAmount).'</b>';
                })
                ->addColumn('orderStatus', function($row){
                    $status=['1'=>'Accepted', '2'=>'Dispatch', '3'=>'Shipping', '4'=>'Delivered', '5'=>'Completed'];
                    return $status[$row->orderStatus];
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <a href= "'.route('pos.sales.orders.getInvoicePrint', ['id' => $row->id] ).'"> <button onclick="getInvoicePrint('.$row->id.')" class="delete btn btn-warning btn-sm"><i class="fa-light fa-print"></i></button></a>
                    <button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button>
                     ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $id = $request->all();
        $data = Orders::where('id', $id)->get();    

        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customers $customers)
    {        echo "hi";die;
        $data['full_name']=$request->input('fullname');
        $data['mobile']=$request->input('mobile');
        $data['email']=$request->input('email');
        $data['address']=$request->input('address');
        $data['pincode']=$request->input('pincode');
        $data['city']=$request->input('city');
        $data['location']=$request->input('location');
        $data['source']=$request->input('source');
        $data['isDealer']=$request->input('isDealer');
        // $data['lastlogin']=Carbon::now()->toDateTimeString();
        // $data['lastlogin_ip']=$request->getClientIp();
        // $data['email_verified']=$request->input('email_verified');
        // $data['mobile_verified']=$request->input('mobile_verified');


        if($request->file('photo'))
        {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $imageName = 'emp'.time().'.'.$request->photo->extension();  
            if($request->photo->move(public_path('customerphotos'), $imageName))
            $data['photo']=$imageName;
        }

        if(Orders::where('id', $request->input('id'))->update($data))
            return redirect(route('pos.sales.orders'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Orders::where('id', $request->id)->delete();
        return response()->json($data);
    }
    public function getProductsSearch(Request $request)
    {
            $products = Products::where('productName','like', '%'. $request->product .'%')
                                    ->orWhere('sku','like', '%'. $request->product .'%')->get();

        $productsMatch='';
        foreach($products as $product){
            $productsMatch.= '<li class="list-group-item list-group-item-action itemRow" id="p**'.$product->id.'" onclick="addProduct('.$product->id.',\''.$product->productName.'\','.$product->price.')">';
            $productsMatch.= preg_replace("/".$request->product."/i", '<strong style="color:black;">'.$request->product.'</strong>', $product->sku);
            $productsMatch.= ' - '.preg_replace("/".$request->product."/i",'<strong style="color:black;">'.$request->product.'</strong>', $product->productName);
            $productsMatch.= '</li>';
        }
        return response()->json($productsMatch);
    }
    public function getInvoicePrint(Request $request)
    {
        //dd($request->input());
            $data = Orders::where('orders.id',$request->input('id'))->join('customers','customers.id','=','orders.customerId')
                                        ->select('orders.*','customers.id as idCustomer',
                                        'customers.full_name',
                                        'customers.mobile',
                                        'customers.pincode',
                                        'customers.address',)
                                        ->get()->first();

                                     //   dd($data);
            $invoice['orderId']= $data->id;
            $invoice['customerId']= $data->customerId;
            $invoice['full_name']= $data->full_name;
            $invoice['mobile']= $data->mobile;
            
            $invoice['invoiceId']= $data->invoiceId;
            $invoice['address']=$data->address; 
            $invoice['city']=$data->city;
            $invoice['pincode']=$data->pincode;     
            $invoice['paymentMode']=$data->paymentMode; 
                
             $items=OrdersItems::where('orderId',$request->input('id'))->get();
             $invoice['items']='';

             foreach($items as $item)
             {
                $product=Products::where('id',$item->itemId)->get()->first();
         
                $invoice['items'].=' <tr align="center">
                                        <td>'.$product->sku.'</td>
                                        <td>'.$product->productName.'</td>
                                        <td>'.number_format((float)$product->price, 2, '.', '').'</td>
                                        <td>'.$item->quantity.'</td>
                                        <td>'.number_format(((float)$product->price*(float)$item->quantity), 2, '.', '').'</td>
                                    </tr>' ;
             }
             $invoice['totalAmount']=$data->totalAmount; 
             $invoice['discountAmount']=$data->discountAmount; 
             $invoice['discountPercent']=$data->discountPercent; 
             $invoice['paidAmount']=$data->totalAmount; //paidAmount is payable
             $invoice['date']=$data->dateCreated;
             

             if(isset($data->shipping))
             {
                $invoice['shippingCharge']='400';
             }

             if(isset($data->partialPayDetails))
             {
                $invoice['partpay']=1;
                
                $partPay=json_decode($data->partialPayDetails,true); 

                $invoice['currentPay']=$partPay['partialAmount'];
                $invoice['nextPayDate']=$partPay['nextPayDate'];
                $invoice['dueAmount']=(float)$data->totalAmount - (float)$data->paidAmount;
             }
             
             

        $pdf = PDF::loadView('pos.sales.invoice',$invoice);

        return $pdf->download('invoice_clsmn.pdf');
    }

}
