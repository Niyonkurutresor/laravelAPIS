<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->except(['getStudents']);
    // }

    public function getStudents(){
        $student = Students::all();
        $data = [
            'status' => 'res',
            'response' => $student
        ];
        return response()->json($data, 201);
    }

    public function findSingle( $id){
        try{
            $student = Students::where('id', $id)->first();

            if(empty($student)){
                return response()->json(['Message'=>'Invalid Id'],404);
            }
            return response()->json($student, 200);

        }catch(\Throwable $e){
            return response()->json(['Message'=>'INTERNAL SERVER ERROR','error'=>$e->getMessage()],500);
        }
    }

    public function createStudent(Request $request){
        $valid = $request->validate( [
            'name' => 'required|string|min:3|max:50' ,
            'age' => 'required|integer'  ,
            'location' => 'required|string'  ,
            'regNo' => 'required|string'  
 
        ]);

       $student = Students::created($valid);
         return response()->json(['message'=>'User created successfully!', 'data'=>$student],201);
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string|min:3|max:50' ,
            'age' => 'required|integer'  ,
            'location' => 'required|string'  ,
            'regNo' => 'required|string'  
 
        ]);

        $student = Students::where('id', $id)->first();
        if(empty($student)){
            return response()->json(['message'=>'Invalid Id']);
        }

        $student->update([
            'name' => $request->name,
            'age'=> $request->age,
            'location' =>$request->location,
            'regNo' => $request->regNo,
        ]);

        return response()->json(
            [
                'message'=>'Student updated successfully!', 
                'Student'=>$student 
            ]);
    }

    public function delete(Request $request,$id){
        $student = Students::where('id', $id)->first();
        if(empty($student)){
            return response()->json(['message'=>'Invalid Id'],404);
        }
       
        $student->delete();
        return response()->json(['message'=>'User deleted successfully!'],404);
        
    }

}