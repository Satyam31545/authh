<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\User;
use App\Models\User_assin_product;
use App\Models\Product;
use Spatie\Permission\Models\Role;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use DB;
use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-assign', ['only' => ['assign_product_p','assign_product']]);
        $this->middleware('permission:product-remove', ['only' => ['deassign_product']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id= Auth::user()->id;
        $my_employee = Employee::with("families")->with("education")->where('id',$id)->first();
         $role=  User::find($my_employee->user_id)->getRoleNames()[0];
        $data = compact('my_employee','role'); 
       
       
        return  view('view')->with($data);
    }
    public function logout(){
        session()->flush();
        return redirect('/');
       }


       public function update(){
        $id= Auth::user()->id;
        $emp = Employee::where('id',$id)->get();
        $data = compact('emp');
    return  view('s_update')->with($data);
       } 

       public function p_update(request $req){
        try {
                    $id= Auth::user()->id;
        $emp = employee::find($id);
        $emp->dob = $req['dob'];
        $emp->address = $req['address'];
        $emp->save(); 
    } catch (\Exception $e) {
        return $e->getMessage();
        }

     }

     public function assign_product($id){

        $array= User_assin_product::where("user_id",$id)->pluck('product_id')->all();

    $toassign = Product::all()->except($array);
//     echo "<pre>";
// print_r($toassign);

    $assigned= User_assin_product::where("user_id",$id)->with("products")->get();


$data = compact('toassign','assigned','id');  
return view("assign_product")->with($data);
       } 

     public function deassign_product($id){
        User_assin_product::where("id",$id)->delete();
        return redirect()->back();
       } 
       public function assign_product_p($id,request $req){

       
        try {
        DB::table('user_assin_products')->insert(['user_id' => $id,'product_id' => $req['product_id']]);
    } catch (\Exception $e) {
        return $e->getMessage();
        }

     }

     public function pdf(){

        $employe=employee::where('id',1)->get();
        $data = compact('employe'); 
        $pdfd = PDF::loadView('pdf',$data);
        return $pdfd->stream();
       } 

       public function myproduct(){
        $id= Auth::user()->id;
        $products= User_assin_product::where("user_id",$id)->with("products")->get();


        $data = compact('products');  
        return view("myproduct")->with($data);
       }
}
