<?php

namespace App\Http\Controllers\Pos\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Specifications;
use App\Models\Inventory\Vendors;
use App\Models\Inventory\Stocks;
use App\Models\Inventory\Categories;
use App\Models\Inventory\ProductImages;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Stocks::get();

        return view('pos.inventory.stocks', compact('data'));
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
        $data['date']=date("Y-m-d");

        $data['vendorId']=$request->input('vendorId');

        foreach($request->input() as $key => $value)
        {
            if(substr($key,0,6)=="price-")
            {
              $productId=substr($key,6);
              $data['productId']=substr($key,6);
              $data['pricePerUnit']=$value;
              $data['quantity']=$request->input('quantity-'.$productId);

              $stockLatest=Stocks::orderBy('id','desc')->first();
              if(isset($stockLatest->batch))
              {   
                  $num='0001';
                  if(!strcmp(date("y").date("m").date("d"),  substr($stockLatest->batch, 0,6)))
                  {
                      $num=((int)substr($stockLatest->batch, 6))+1;
                      $num=str_pad($num, 4, "0", STR_PAD_LEFT);
                  }
                  $data['batch']=date("y").date("m").date("d").$num;
              }
              else 
              {
                $data['batch']=date("y").date("m").date("d").'0001';
              }

                 Stocks::insert($data);
            }
        }


        return redirect(route('pos.inventory.stocks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            //$data = Stocks::latest()->get();
            $data = Stocks::leftjoin('products','stocks.productId','=','products.id')
                        ->select('stocks.*','products.productName')
                        ->orderBy('id','desc')
                        ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = 
                    '<button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> 
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
        // $data = Stocks::leftjoin('categories','categories.id','=','products.categoryId')
        //                 ->select('products.*','categories.name as categoryName')
        //                 ->where('products.id', $id)
        //                 ->orderBy('products.id','desc')
        //                 ->get();
        $data = Stocks::where('id', $id)->get();
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data['name']=$request->input('vendorName');
        $data['companyName']=$request->input('companyName');
        $data['mobile']=$request->input('mobile');
        $data['email']=$request->input('email');
        $data['address']=$request->input('address');

         Stocks::where('id',$request->input('id'))->update($data);

        return redirect(route('pos.inventory.stocks'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(Stocks::where('id', $request->id)->delete())
        return response()->json(['status'=>'success','data'=>$request->id],200);
        else
        return response()->json(['status'=>'failed','data'=>$request->id],500);
    }

  

    public function freshForm($specs):string
    {
        $formItems="";

        foreach($specs as $spec)
        {
            $fieldName=$spec->name.'**';
            if($spec->type=='text')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.':</label>
                  <input class="form-control" type="text" id="'.$spec->name.'" name="'.$fieldName.'" value="'.$spec->content.'" required>
                </div>
              </div>';
            }
            else if($spec->type=='dropdown')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.'</label>
                  <select class="form-control" id="'.$spec->name.'" name="'.$fieldName.'"  required>';
                  
                  $options=json_decode($spec->content, true);  
                  foreach($options as $option)
                  {
                    $formItems.='<option value="'.$option.'">'.$option.'</option>';
                  }
                
                  $formItems.=
                '</select>
                </div>
              </div>';
            }
            else if($spec->type=='boolean')
            {
                $formItems.=
                '<div class="col-md-6">
                   <div class="form-group">'
                   .$spec->name.
                    ':<br><input  type="radio" id="'.$spec->name.'_1" name="'.$fieldName.'" value="1" '.(($spec->content=='1')?'checked':'').'>
                     <label for="'.$spec->name.'_0">Yes</label><br>
                     <input  type="radio" id="'.$spec->name.'_0" name="'.$fieldName.'" value="0" '.(($spec->content=='0')?'checked':'').'>
                     <label for="'.$spec->name.'_0">No</label>
                   </div>
                 </div>';
            }
        }   
        return $formItems;
    }
    public function editForm($prodId, $specs):string
    {
       $formItems="";
        
        if($prodId)
        {
            $productSpecs=Stocks::where('id', $prodId)->get()->first()->specifications;
        }

        $productSpecs=json_decode($productSpecs, true);

        foreach($specs as $spec)
        {
            $fieldName=$spec->name.'**';
            if($spec->type=='text')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.':</label>
                  <input class="form-control" type="text" id="'.$spec->name.'" name="'.$fieldName.'" value="'.$productSpecs[str_replace(' ','_',$spec->name)].'" required>
                </div>
              </div>';
            }
            else if($spec->type=='dropdown')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.'</label>
                  <select class="form-control" id="'.$spec->name.'" name="'.$fieldName.'"  required>';
                  
                  $options=json_decode($spec->content, true);  
                  foreach($options as $option)
                  {
                    $formItems.='<option value="'.$option.'">'.$option.'</option>';
                  }
                
                  $formItems.=
                '</select>
                </div>
              </div>';
            }
            else if($spec->type=='boolean')
            {
                $formItems.=
                '<div class="col-md-6">
                   <div class="form-group">'
                   .$spec->name.
                    ':<br><input  type="radio" id="'.$spec->name.'_1" name="'.$fieldName.'" value="1" '.(($productSpecs[str_replace(' ','_',$spec->name)]=='1')?'checked':'').'>
                     <label for="'.$spec->name.'_0">Yes</label><br>
                     <input  type="radio" id="'.$spec->name.'_0" name="'.$fieldName.'" value="0" '.(($productSpecs[str_replace(' ','_',$spec->name)]=='0')?'checked':'').'>
                     <label for="'.$spec->name.'_0">No</label>
                   </div>
                 </div>';
            }
        }
        
        
        return $formItems;
    }
    public function addUpdateImages(Request $request)
    {
        if($request->productImages)
        {
            $request->validate([
                'productImages' => 'required',
                'productImages.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            $i=1;
            foreach($request->productImages as $image)
            {

                $imageName = $i++.'pImg'.time().'.'.$image->extension();  
                if($image->move(public_path('productImages'), $imageName))
                $data['image']=$imageName;
                $data['productId']=$request->input('productId-1');

                ProductImages::insert($data);
            }

        }
        return redirect(route('pos.inventory.stocks'));
    }
    public function getVendorsSearch(Request $request)
    {
            $vendors = Vendors::where('mobile','like', '%'. $request->vendor .'%')
                                    ->orWhere('name','like', '%'. $request->vendor .'%')->get();

        $vendorsMatch='';
        foreach($vendors as $vendor){
            $vendorsMatch.='<li class="list-group-item list-group-item-action" onclick="getVendorDetails('.$vendor->id.',\''.$vendor->name.'\',\''.$vendor->companyName.'\')">';
            $vendorsMatch.=preg_replace("/".$request->mobile."/i", '<strong style="color:black;">'.$request->mobile.'</strong>', $vendor->mobile);
            $vendorsMatch.=' - '.$vendor->companyName;
            $vendorsMatch.='</li>';
        }
        return response()->json($vendorsMatch);
    }

}

