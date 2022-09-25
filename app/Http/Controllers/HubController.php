<?php

namespace App\Http\Controllers;
use App\Hub;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Keygen;


class HubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_warehouse_all = Hub::where('is_active', true)->orderBy('id','DESC')->get();
        return view('hub.create', compact('lims_warehouse_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
       // dd($input);
        $input['is_active'] = true;
        Hub::create($input);
        return redirect('hub')->with('message', 'Data inserted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_warehouse_data = Hub::findOrFail($id);
        return $lims_warehouse_data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validate($request, [
//            'name' => [
//                'max:255',
//                Rule::unique('hubs')->ignore($request->hub_id)->where(function ($query) {
//                    return $query->where('is_active', 1);
//                }),
//            ],
//        ]);
        $input = $request->all();
        $lims_warehouse_data = Hub::find($input['hub_id']);
        $lims_warehouse_data->update($input);
        return redirect('hub')->with('message', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lims_warehouse_data = Hub::find($id);
        $lims_warehouse_data->is_active = false;
        $lims_warehouse_data->save();
        return redirect('hub')->with('not_permitted', 'Data deleted successfully');
    }
}
