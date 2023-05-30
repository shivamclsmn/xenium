<?php
namespace App\Http\Controllers\Pos\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Leads;
use App\Models\CRM\Customers;
use App\Models\Inventory\Products;
use App\Models\CRM\Leads_source;
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
            Leads::insert($data);
        }
        else
        {
            $data_1['location']=$request->input('location');
            $data_1['full_name']=$request->input('fullname');
            $data_1['mobile']=$request->input('mobile');
            $data_1['email']=$request->input('email');

            $id=Customers::insertGetId($data_1);
            $data['customer_id']=$id;
            Leads::insert($data);
        }
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
                        ->orderBy('customer_id','desc')->get();
                        

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
                    $actionBtn = '<button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> <button onclick="delData('.$row->id.')" class="delete btn btn-danger btn-sm"><i class="fa-light fa-trash"></i></button>';
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
        $data = Leads::where('id', $id)->get();    

        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leads $leads)
    {
        //

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

        if(Leads::where('id', $request->input('id'))->update($data))
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
