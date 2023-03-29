<?php

namespace App\Http\Controllers\Pos\HRMS;

use App\Http\Controllers\Controller;
use App\Models\HRMS\Positions;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pos.hrms.positions.index');
    }

    public function getPositions(Request $request) {
        //
        if ($request->ajax()) {
            $data = Positions::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        //
        $validate = $request->validate([
            'position' => ['required','max: 32','unique:'.Positions::class],
            'max_pos' => ['numeric'],
            'details' => ['max: 255'],
        ]);
        $position = Positions::create($data);   
        return response()->json(['success', 'Position added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Positions $positions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Positions $positions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Positions $positions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Positions $positions)
    {
        //
    }
}
