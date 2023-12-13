<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'suppliers';
        if ($request->ajax()) {
            $suppliers = Supplier::get();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('created_at', function ($suppliers) {
                    return date_format(date_create($suppliers->created_at), "d M,Y");
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a data-id="' . $row->id . '" data-name="' . $row->name . '" data-phone="' . $row->phone . '" data-email="' . $row->email . '" data-address="' . $row->address . '"
                    data-product="' . $row->product . '" data-company="' . $row->company . '" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="' . $row->id . '" data-route="' . route('suppliers.destroy', $row->id) . '" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-supplier')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-supplier')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn . ' ' . $deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.suppliers', compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create supplier';
        return view('admin.master.suppliers', compact(
            'title'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:10|max:255',
            'product' => 'required',
            'email' => 'nullable|email|string',
            'phone' => 'nullable|min:10|max:20',
            'company' => 'nullable|max:200|required',
            'address' => 'nullable|required|max:200',
            'comment' => 'nullable|max:255',
        ]);
        Supplier::create($request->all());
        $notification = notify("Supplier has been added");
        return back()->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    // public function edit(Supplier $supplier)
    // {
    //     $title = 'edit supplier';
    //     return view('admin.suppliers.index', compact(
    //         'title',
    //         'supplier'
    //     ));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:10|max:255',
            'product' => 'required',
            'email' => 'nullable|email|string',
            'phone' => 'nullable|min:10|max:20',
            'company' => 'nullable|max:200|required',
            'address' => 'nullable|required|max:200',
            'comment' => 'nullable|max:255',
        ]);
        $supplier = Supplier::find($request->id);
        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'product' => $request->product,
            'comment' => $request->comment,
        ]);
        $notification = notify("Supplier has been added");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Supplier::findOrFail($request->id)->delete();
    }
}
