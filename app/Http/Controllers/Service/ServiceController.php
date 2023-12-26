<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories  = CategoryService::all();
        if ($request->ajax()) {
            $data = Service::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._action_dinamyc', [
                        'model'           => $data,
                        'delete'          => route('service.destroy', $data->id),
                        'edit'          => route('service.edit', $data->id),
                        'confirm_message' =>  'Anda akan menghapus data "' . $data->name . '" ?',
                        'padding'         => '85px',
                    ]);
                })
                ->addColumn('price', function ($data) {
                    return "Rp. ".number_format($data->price, 0,',','.');
                })
                ->addColumn('commission', function ($data) {
                    return "Rp. ".number_format($data->commission, 0,',','.');
                })
                ->addColumn('is_active', function ($data) {
                    return $data->is_active ? 'Aktif' : "Tidak Aktif";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content/service', compact('categories'));
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
            'category_id' =>'required',
            'name'  =>'required',
            'price' =>'required',
            'commission' =>'required',
            'is_active' =>'required',
        ]);
        try {
         

            Service::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'commission' => $request->commission,
                'is_active' => $request->is_active,
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
        $category = Service::find($id);

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
            $category = Service::find($id);

  
                $category->update([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'commission' => $request->commission,
                    'is_active' => $request->is_active,
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
            $category = Service::find($id);
            $category->delete();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
