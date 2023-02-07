<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;

class FamilyController extends Controller
{
    public function create($id)
    {
        $data = compact('id');  
        return  view('family')->with($data); 
    }
    public function store($id ,request $req)
    {
        try {
                    $emp_id_g=$req['emp_id'];
        for( $i=1;$i<$req['add'];$i++){
       
        $Emp_fam = new Family;
        $Emp_fam->employee_id=$emp_id_g;
        $Emp_fam->name=$req['name'.$i];
        $Emp_fam->age=$req['age'.$i];
        $Emp_fam->relation=$req['relation'.$i];
        $Emp_fam->employeed=$req['employed'.$i];
        $Emp_fam->save();
        }
    } catch (\Exception $e) {
        return $e->getMessage();
        }
        

       
    }
}
