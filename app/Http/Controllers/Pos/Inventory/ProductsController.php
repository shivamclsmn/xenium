<?php

namespace App\Http\Controllers\Pos\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Specifications;
use App\Models\Inventory\Products;
use App\Models\Inventory\Categories;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Products::get();
        $categories = Categories::get();
        return view('pos.inventory.products', compact('data','categories'));
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
        $data['productName']=$request->input('productName');
        $data['categoryId']=$request->input('productCategory');
        $data['price']=$request->input('productPrice');
        $data['quantity']=$request->input('productQuantity');
        $data['isFeatured']=$request->input('isFeatured');
        $data['status']=$request->input('status'); 
       

        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $arrSpecs=[];//array_diff($request->input(),$data);    

         foreach($request->input() as $name=>$value)
         {
            if(substr($name,-2)=='**')
            $arrSpecs[rtrim($name,'*')]=$value;
         }
         $data['specifications']=json_encode($arrSpecs);
        //  print_r($data);die;
        // dd($data);
        $pid=Products::insertGetId($data);

         $prefix=Categories::where('id',$request->input('productCategory'))->get()->first()->prefix;

         define( 'SKU_Length' , 7);
         $sku='';
         for($zeros='';  strlen( $sku) < SKU_Length ;$zeros.='0') $sku=$prefix . $zeros . $pid;

         Products::where('id',$pid)->update(['sku'=>$sku]);

        return redirect(route('pos.inventory.products'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Products::latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('productId', function($row){
                    return $row->id;
                })
                ->addColumn('name', function($row){
                    return $row->name.'<br>'.$row->email.'</b>';
                })
                ->addColumn('tags', function($row){
                    return $row->tags;
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
        $data = Products::where('id', $id)->get();
        $data[0]->tags=join(',',json_decode($data[0]->tags, true));
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data['name']=$request->input('productName');
        
        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $data['isActive']=$request->input('isActive');

        if(Products::where('id', $request->input('id'))->update($data))
            return redirect(route('pos.inventory.products'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Products::where('id', $request->id)->delete();
        return response()->json($data);
    }

    public function getSpecForm(Request $request)
    {
        $specs = Specifications::where('categoryId', $request->id)->get();
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
                     <input  type="radio" id="'.$spec->name.'_0" name="'.$spec->name.'" value="0" '.(($spec->content=='0')?'checked':'').'>
                     <label for="'.$spec->name.'_0">No</label>
                   </div>
                 </div>';
            }
        }
        
        
        return response()->json($formItems);
    }
}
