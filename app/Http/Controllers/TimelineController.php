<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timeline;

class TimelineController extends Controller
{
    //

     public function index()
    {
        //$data['result']  =   \App\Timeline::take(2)->get();
        $data['result']  =   \App\Timeline::all();
        return view ('timeline.index')->with($data);
    }


    public function create()
    {
        //
        return view ('timeline.form');
    }


    public function store(Request $request)
    {
        $validate =[
          'nama_event' => 'required',
          'lokasi' => 'required'
        ];

        $this->validate($request,$validate);
        $input = $request->all();
        if($request->hasFile('foto'))
        {
          $filename = $request->file('foto')->getClientOriginalName();
          $request->file('foto')->storeAs('',$filename);
          $input['foto'] = $filename;
        }
        Timeline::create($input);
        return redirect('timeline')->with('success','Item Created Successfully');
    }

    public function edit($id)
    {
       $data['timeline'] = Timeline::find($id);

        return view('event.form')->with($data);
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
        $validate =[
          'nama_event' => 'required',
          'lokasi' => 'required'
        ];

        $this->validate($request,$validate);

        $input = $request->all();
        $timeline = Timeline::find($id);
        $timeline->update($input);
        return redirect('timeline')->with('success','Item Edited Successfully');
    }

    public function destroy($id)
    {
       $timeline = Timeline::find($id);

      $timeline->delete();
      return redirect('timeline')->with('success','Item Deleted Successfully');
    }
}
