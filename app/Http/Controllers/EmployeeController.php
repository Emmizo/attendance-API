<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Employee;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::all();
        return response()->json(["message"=>"success","data"=>$data,"status"=>200]);
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
            'f_name'=>'required|string',
            'l_name' => 'required|string',
            'email'=>'required|string|email|unique:employees',
            'employee_identifier'=>'required|min:16|max:16|unique:employees',
            'phone_number' => 'required'
        ]);
        if ($validation->fails())
        {
            return response(['errors'=>$validation->errors()->all()], 401);
        }
        $emp = Employee::create([
            'f_name'=> $request->f_name,
            'l_name'=>$request->l_name,
            'email' =>$request->email,
            'user_id' => auth()->user()->id,
            'employee_identifier' => $request->employee_identifier,
            'phone_number' => $request->phone_number
        ]);
        return response()->json(['message'=>'success','status'=>201]);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request)
    {
        $validation =Validator::make($request->all(), [
            'f_name'=>'required|string',
            'l_name' => 'required|string',
            'email'=> 'required|string|email|unique:employees,email,'.$request->id,
            'employee_identifier'=>'required|min:16|max:16|unique:employees,employee_identifier,'.$request->id,
            'phone_number' => 'required|unique:employees,phone_number,'.$request->id
        ]);
        if ($validation->fails())
        {
            return response(['errors'=>$validation->errors()->all()], 401);
        }
        
            $emp = Employee::find($request->id);
            if($emp){
            $emp->f_name= $request->f_name;
            $emp->l_name=$request->l_name;
            $emp->email =$request->email;
            $emp->user_id = auth()->user()->id;
            $emp->employee_identifier = $request->employee_identifier;
            $emp->phone_number = $request->phone_number;
            $emp->save();
        return response()->json(['message'=>'success employee data updated','status'=>200]);
            }else{
                return response()->json(["message"=> "Employee id of"." ".$request->id.", doesn't exist","status"=>404]);
                
            }
            
        //
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}