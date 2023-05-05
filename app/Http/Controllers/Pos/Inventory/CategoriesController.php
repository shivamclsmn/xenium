<?php

namespace App\Http\Controllers\Pos\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Specifications;
use App\Models\Inventory\Categories;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Categories::get();
        return view('pos.inventory.categories', compact('data'));
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
        $data['name']=$request->input('categoryName');
        
        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $data['isActive']=$request->input('isActive');

        //dd($data);
        if(Categories::insert($data))
        return redirect(route('pos.inventory.categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Categories::latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('categoryId', function($row){
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
        $data = Categories::where('id', $id)->get();
        $data[0]->tags=join(',',json_decode($data[0]->tags, true));
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data['name']=$request->input('categoryName');
        
        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $data['isActive']=$request->input('isActive');

        if(Categories::where('id', $request->input('id'))->update($data))
            return redirect(route('pos.inventory.categories'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Categories::where('id', $request->id)->delete();
        return response()->json($data);
    }
}
