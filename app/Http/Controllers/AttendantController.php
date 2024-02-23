<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\Employee;
use Illuminate\Http\Request;
use Validator;
use App\Events\startedEvent;
use App\Events\endedEvent;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendantExport;

class AttendantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Attendant::join('users','users.id','attendants.user_id')
        ->join('employees','employees.id','attendants.emp_id')
        ->select('attendants.id as attendant_id','employees.*','users.name as created_by' ,'attendants.started_at','attendants.ended_at','attendants.status')
        ->orderBy('attendants.updated_at','desc')->get();
        return response()->json(['message'=> "success","data"=>$list,"status"=>200]);
        //
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
        $validation =Validator::make($request->all(), [
            'emp_id'=>'required|integer|exists:employees,id',
            'started_at' => 'required|date_format:H:i',
        ]);
        if ($validation->fails())
        {
            return response(['errors'=>$validation->errors()->all()], 401);
        }
        $emp= Employee::select('f_name','l_name','email')->where('id',$request->emp_id)->first();
       $info['email'] = $emp->email;
       $info['f_name'] = $emp->f_name;
       $info['l_name'] = $emp->l_name;
       $info['emp_id'] = $request->emp_id;
       $info['user_id'] = auth()->user()->id;
       $info['started_at'] = $request->started_at;
       
       event(new startedEvent($info));
        $attendant = Attendant::create($info);
        return response()->json(["message"=> "you started at"." ".$request->started_at,"status"=>200]);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendant $attendant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendant $attendant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendant $attendant)
    {
        $validation =Validator::make($request->all(), [
            'attendant_id'=>'required|integer|exists:attendants,id',
            'ended_at' => 'required|date_format:H:i',
        ]);
        if ($validation->fails())
        {
            return response(['errors'=>$validation->errors()->all()], 401);
        }
       
        $attendant = $attendant::find($request->attendant_id);
        $emp= Employee::select('f_name','l_name','email')->where('id',$attendant->emp_id)->first();
        $info['email'] = $emp->email;
        $info['f_name'] = $emp->f_name;
        $info['l_name'] = $emp->l_name;
       
        $info['ended_at'] = $request->ended_at;
        
        event(new endedEvent($info));
        $attendant->ended_at = $request->ended_at;
        $attendant->save();
        return response()->json(["message"=> "you exit at"." ".$request->ended_at,"status"=>200]);
        
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendant $attendant)
    {
        //
    }

    //PDF report

    public function PDFReport(){
        $list = Attendant::join('users','users.id','attendants.user_id')
        ->join('employees','employees.id','attendants.emp_id')
        ->select('attendants.id as attendant_id','employees.*','users.name as created_by' ,'attendants.started_at','attendants.ended_at','attendants.status')
        ->orderBy('attendants.updated_at','desc')->get();

        // Generate PDF report
        $data = \PDF::loadView('reports.attendance', ["list"=>$list])->output();

        return \Response::make($data, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="attendance.pdf"'
        ]);
        
    } 


    public function excelReport(){

        return \Excel::download(new Attendant,'attendance.xlsx');
    }
}