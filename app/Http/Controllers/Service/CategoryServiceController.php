<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Yajra\DataTables\DataTables;

class CategoryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CategoryService::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._action_dinamyc', [
                        'model'           => $data,
                        'delete'          => route('category-service.destroy', $data->id),
                        'edit'          => route('category-service.edit', $data->id),
                        'confirm_message' =>  'Anda akan menghapus data "' . $data->name . '" ?',
                        'padding'         => '85px',
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content/category-service');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
         

            CategoryService::create([
                'name' => $request->name,
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = CategoryService::find($id);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = CategoryService::find($id);

  
                $category->update([
                    'name' => $request->name,
                ]);

        
       
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = CategoryService::find($id);
            $category->delete();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
