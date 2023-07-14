<?php
namespace App\Http\Controllers\Pos\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Leads;
use App\Models\CRM\Customers;
use App\Models\Inventory\Products;
use App\Models\CRM\Leads_history;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$customers = Leads::where('isDealer','0')->get();
        $leads = Leads::leftjoin('customers','leads.customer_id','=','customers.id')
                    ->select('leads.*','customers.id as customerId', 'customers.full_name',
                    'customers.mobile','customers.email','customers.address', 'customers.pincode',
                    'customers.city','customers.location')    
                    ->get();
        return view('pos.crm.leads', compact('leads'));
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
        $data['source_id']=$request->input('source');
       // $data['isDealer']=$request->input('isDealer');
        $data['description']=$request->input('description');
        $data['status']=1;
        $data['nextCallingDate']=$request->input('nextCallingDate');
        if($request->input('products'))
        {
            $str="-".$request->input('products')."-";
            $products = explode("--",$str);
            unset($products[count($products)-1]);
            unset($products[0]);
            $products=array_values($products);
            $data['product_ids']=json_encode($products);
        }

        $data['nextCallingDate']=$request->input('nextCallingDate');
        $data['user_id'] = Auth::user()->id;

        if($request->input('customerId'))
        {
            $data['customer_id']=$request->input('customerId');
            $leadId=Leads::insertGetId($data);
        }
        else
        {
            $data_1['location']=$request->input('location');
            $data_1['full_name']=$request->input('fullname');
            $data_1['mobile']=$request->input('mobile');
            $data_1['email']=$request->input('email');

            $id=Customers::insertGetId($data_1);
            $data['customer_id']=$id;
            $leadId=Leads::insertGetId($data);
        }
        $data_2['commentType']= $request->input('commentType');
        $data_2['comment']= $request->input('comment');
        $data_2['status']= $request->input('status');
        $data_2['user_id']=($request->input('userAssigned'))? $request->input('userAssigned') : (Auth::user()->id);
        $data_2['nextCallingDate']= $request->input('nextCallingDate');
        $data_2['lead_id']= $leadId;
        Leads_history::insert($data_2);

        return redirect(route('pos.crm.leads'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Leads::leftjoin('customers','customers.id','=','leads.customer_id')
                        ->select('leads.*','customers.id as custtomerId',
                        'customers.full_name',
                        'customers.mobile',
                        'customers.email',
                        'customers.address')
                        ->orderBy('nextCallingDate','asc')->get();
                        

            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('lead_id', function($row){
                    return $row->id;
                })
                ->addColumn('personal_info', function($row){
                    return $row->full_name;
                })
                ->addColumn('contact_info', function($row){
                    return $row->mobile.'<br>'.$row->email.'</b>';
                })
                ->addColumn('address', function($row){
                    return $row->address;
                })
                ->addColumn('action', function($row){
                    $actionBtn = 
                    '<button onclick="getHistory('.$row->id.')" data-toggle="modal" data-target="#leadHistoryModal" class="edit btn btn-info btn-sm">View History</button>
                    <button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> 
                   ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make(true);
        }
    }
    public function getHistory(Request $request)
    {
            $histories = Leads_history::where('lead_id',$request->all())
                                        ->leftjoin('users','users.id','=','leads_histories.user_id')
                                        ->select('leads_histories.*','users.name as userName')
                                        ->get();
            $data='';
            $i=1;
            $status=['1'=>'Hot','2'=>'Mild','3'=>'Cold','4'=>'Sold','5'=>'Dead'];
            $statusColor=['1'=>'red','2'=>'magenta','3'=>'#0aa','4'=>'green','5'=>'black'];
            foreach($histories as $history)
            {
                $data.=
                '<tr>
                <td>'.$i++.'</td>
                <td>'.$history->id.'</td>
                <td>'.$history->comment.'</td>
                <td>'.$history->userName.'</td>
                <td>'.($history->commentType?'User':'Customer').'</td>
                <td><span style="color:'.$statusColor[$history->status].'">'.$status[$history->status].'</span></td>
                <td>'.$history->nextCallingDate.'</td>
              </tr>';
            }
            return response()->json($data);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->all();
        $data['lead'] = Leads::where('leads.id', $id)->get()->first();
        //$data['lead']->product_ids=join(',',json_decode($data[0]->tags, true));
        $products=json_decode($data['lead']->product_ids, true);
        if(!empty($products))
        {
            $str='';
            foreach($products as $product)
            {
                $pname=Products::where('id',str_replace("\"",'',$product))->get()->first()->productName;
                $str.='<span class="border bg-light px-1 py-1 w-25" >'.$pname.'<span>&nbsp&nbsp';
            }
            $data['lead']->product_ids=$str;
        }

        $data['customer'] = Customers::where('id', $data['lead']->first()->customer_id)->get()->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leads $leads)
    {
        $data['commentType']= $request->input('commentType');
        $data['comment']= $request->input('comment');
        $data['status']= $request->input('status');
        $data['user_id']=($request->input('userAssigned'))? $request->input('userAssigned') : (Auth::user()->id);
        $data['nextCallingDate']= $request->input('nextCallingDate');
        $data['lead_id']= $request->input('id');


        if(Leads_history::insert($data))
            return redirect(route('pos.crm.leads'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Leads::where('id', $request->mobile)->delete();
        return response()->json($data);
    }
    public function getCustomersSearch(Request $request)
    {
            $customers = Customers::where('mobile','like', '%'. $request->mobile .'%')->get();

        $customersMatch='';
        foreach($customers as $customer){
            $customersMatch.='<li class="list-group-item list-group-item-action" onclick="getCustomerDetails('.$customer->id.')">';
            $customersMatch.=preg_replace("/".$request->mobile."/i", '<strong style="color:black;">'.$request->mobile.'</strong>', $customer->mobile);
            $customersMatch.=' - '.$customer->full_name;
            $customersMatch.='</li>';
        }
        return response()->json($customersMatch);
    }
    public function getProductsSearch(Request $request)
    {
            $products = Products::where('productName','like', '%'. $request->product .'%')
                                    ->orWhere('sku','like', '%'. $request->product .'%')->get();

        $productsMatch='';
        foreach($products as $product){
            $productsMatch.= '<li class="list-group-item list-group-item-action" id="p**'.$product->id.'" onclick="addProduct('.$product->id.',\''.$product->productName.'\')">';
            $productsMatch.= preg_replace("/".$request->product."/i", '<strong style="color:black;">'.$request->product.'</strong>', $product->sku);
            $productsMatch.= ' - '.preg_replace("/".$request->product."/i",'<strong style="color:black;">'.$request->product.'</strong>', $product->productName);
            $productsMatch.= '</li>';
        }
        return response()->json($productsMatch);
    }
    public function getUsersSearch(Request $request)
    {
            $users = User::where('name','like', '%'. $request->user .'%')
                                    ->get();

        $usersMatch='';
        foreach($users as $user){
            $usersMatch.= '<li class="list-group-item list-group-item-action" id="u**'.$user->id.'" onclick="selectUser('.$user->id.',\''.$user->userName.'\')">';
            $usersMatch.= preg_replace("/".$request->user."/i",'<strong style="color:black;">'.$request->user.'</strong>', $user->name);
            $usersMatch.= '</li>';
        }
        return response()->json($usersMatch);
    }
}
