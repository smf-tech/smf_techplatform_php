<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use App\EventType;
use App\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;

class EventTypeController extends Controller
{
    public function index()
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $event_types=EventType::all();

        return view('admin.event_types.index',compact('event_types','orgId'));
        
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $forms = Survey::where('active','true')->get();
        return view('admin.event_types.create',compact('orgId', 'forms'));
    }

    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name' => 'required|unique:event_types'
				],
				$this->messages()
		);

        $event_type = new EventType;
        $event_type->name = $request->name;
        $event_type->associatedForms = $request->associatedForms;
        $event_type->save();

        return redirect()->route('event-types.index',$orgId)->withMessage('Event Type Created');
    }

    public function edit($event_type_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $event_type = EventType::find($event_type_id);
        $forms = Survey::where('active','true')->get();

       return view('admin.event_types.edit',compact('orgId', 'event_type','forms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_type_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name' => 'required'
				],
				$this->messages()
		);
        $event_type = EventType::find($event_type_id);
        $event_type->name=$request->name;
        $event_type->associatedForms = $request->associatedForms;
        $event_type->save();

        return redirect()->route('event-types.index',$orgId)->withMessage('Event Type Updated');
    }

    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        EventType::find($id)->delete();

        return Redirect::back()->withMessage('Event Type Deleted');
    }

	public function messages()
	{
		return [
			'name.required' => 'Event Type name is required.',
			'name.unique' => 'Event Type name has already been taken.'
		];
	}
}
