<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:education-create', ['only' => ['create','store']]);
    }
    public function create($id)
    {
        $data = compact('id');  
        return  view('education')->with($data); 
    }
    public function store($id ,request $req)
    {
        try {
            $emp_id_g=$req['emp_id'];
            for( $i=1;$i<$req['add'];$i++){
           
            $Emp_fam = new Education;
            $Emp_fam->employee_id=$emp_id_g;
            $Emp_fam->edu_level=$req['edu_level'.$i];
            $Emp_fam->course_n=$req['course_n'.$i];
            $Emp_fam->place=$req['place'.$i];
            $Emp_fam->percent=$req['percent'.$i];
            $Emp_fam->save();
            }
           
    } catch (\Exception $e) {
        return $e->getMessage();
        }
        

       
    }
}
