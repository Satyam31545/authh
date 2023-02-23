<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\User;
use App\Models\User_assin_product;
use App\Models\Log;
use App\Models\Product;
use Spatie\Permission\Models\Role;
// use Barryvdh\DomPDF\Facade\Pdf;
use Codedge\Fpdf\Fpdf\Fpdf;
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
       
        $my_employee = Employee::with("families")->with("education")->where('user_id',$id)->first();
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
        DB::transaction(function () use ($id) {
       $u_p = User_assin_product::where("id",$id);
       $qu=$u_p->first();

//    log start
Log::create([
    'changer'=> Auth::user()->id,
    'change_holder'=> $qu->user_id, 
    'operation'=> 'removed',
    'quantity'=> $qu->quantity,
    'product_id'=> $qu->product_id
]);
// log end 

    $pro = Product::find($qu->product_id);
    $pro->quantity = $pro->quantity+$qu->quantity;
    $pro->save(); 
    $u_p->delete();

        });
        return redirect()->back();
       } 
       public function assign_product_p($id,request $req){

       
        try {
        DB::table('user_assin_products')->insert(['user_id' => $id,'product_id' => $req['product_id'],'quantity' => $req['quantity']]);

        $pro = Product::find($req['product_id']);
        $pro->quantity = $pro->quantity-$req['quantity'];

        $pro->save(); 

//    log start
Log::create([
    'changer'=> Auth::user()->id,
    'change_holder'=> $id, 
    'operation'=> 'added',
    'quantity'=> $req['quantity'],
    'product_id'=> $req['product_id']
]);
// log end 

    } catch (\Exception $e) {
        return $e->getMessage();
        }

     }
     
       public function myproduct(){
        $id= Auth::user()->id;
        $products= User_assin_product::where("user_id",$id)->with("products")->get();


        $data = compact('products');  
        return view("myproduct")->with($data);
       }

       public function fpdf(){

        $id= Auth::user();
        $employee= $id->employees()->first();
        $products= User_assin_product::where("user_id",$id->id)->with("products")->get();


        $pdf = new Fpdf;
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',20);

        $pdf->SetFont('Arial','B',15);
        $pdf->Image('pica.png',10,6,20,20);

        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'XYZ company',0,1,'R');

         $pdf->SetFont('Arial','',10);

        $pdf->Cell(59 ,5,'',0,0); 
        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'Address',0,1,'R');

        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'city',0,1,'R');

        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'',0,0);
        $pdf->Cell(59 ,5,'postal',0,1,'R');

        $pdf->Cell(59 ,5,'',0,1);
        $pdf->Line(10, 35, 200,35);
        $pdf->Cell(59 ,5,'',0,1);
        $pdf->SetFont('Arial','B',15);

        $pdf->Cell(89 ,5,'BILL TO :',0,0,'L');
        $pdf->Cell(88 ,5,'INVOICE #',0,1,'R');
        $pdf->SetFont('Arial','',10);

        $pdf->Cell(89 ,5,$employee->name,0,0,'L');
        $pdf->Cell(88 ,5,'0000001',0,1,'R');
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(89 ,5,'Address',0,0,'L');
        $pdf->Cell(88 ,5,'Date',0,1,'R');
        $pdf->SetFont('Arial','',10);

        $pdf->Cell(89 ,5,$employee->address,0,0,'L');
        $pdf->Cell(88 ,5,'12/01/12',0,1,'R');
        $pdf->Line(10, 65, 200,65);

        $pdf->Cell(50 ,10,'',0,1);
        
        $pdf->SetFont('Arial','B',12);
        /*Heading Of the table*/
        $pdf->Cell(10 ,6,'Sl',0,0,'C');
        $pdf->Cell(40 ,6,'Items',0,0,'C');
        $pdf->Cell(50 ,6,'Description',0,0,'C');
        $pdf->Cell(30 ,6,'Qty',0,0,'C');
        $pdf->Cell(20 ,6,'Price',0,0,'C');
        $pdf->Cell(15 ,6,'Tax',0,0,'C');
        $pdf->Cell(20 ,6,'Amount',0,1,'C');/*end of line*/
        /*Heading Of the table end*/
        $pdf->SetFont('Arial','',10);
        $i=0;
        $total=0;
            foreach ($products As $product) {
                ++$i;
                $pdf->Cell(10 ,6,$i,0,0);
                $pdf->Cell(40 ,6,$product->products->name,0,0);
                $pdf->Cell(50 ,6,$product->products->description,0,0);
                $pdf->Cell(30 ,6,$product->products->quantity,0,0);
                $pdf->Cell(20 ,6,$product->products->prize,0,0);
                $pdf->Cell(15 ,6,$product->products->tax,0,0);
                $a=($product->products->quantity*$product->products->prize);
                $a+=($product->products->quantity*$product->products->prize)*($product->products->tax/100);
                $total+=$a;
                $pdf->Cell(20 ,6,$a,0,1,"R");
            }
                
            $pdf->Line(10,($i*6)+ 78, 200,($i*6)+78);

        $pdf->Cell(118 ,6,'',0,1);
        $pdf->Cell(118 ,6,'',0,0);
        $pdf->Cell(25 ,6,'Subtotal',0,0);
        $pdf->Cell(45 ,6,$total,0,1,'R');
        
        
        $pdf->Output();
        exit;
               }  

// increase assined product

public function increase_assined(request $req){

   
    DB::transaction(function () use ($req) {
        $u_p = User_assin_product::find($req['add_id']);
        // $qu=$u_p->first();
      $quantity=  $req["quantity"];
     
 
//  //    log start
 Log::create([
     'changer'=> Auth::user()->id,
     'change_holder'=> $u_p->user_id, 
     'operation'=> 'increase',
     'quantity'=>$quantity ,
     'product_id'=> $u_p->product_id
 ]);
//  // log end 
 $pro = Product::find($u_p->product_id);
    
     $pro->quantity = $pro->quantity-$quantity;
     $pro->save();

 $u_p->quantity = $u_p->quantity+$quantity;
     $u_p->save();
 
         });

        return redirect()->back();
        
 }

//  reject 

public function reject($id){
    DB::transaction(function () use ($id) {
   $u_p = User_assin_product::find($id);
 

//    log start
Log::create([
'changer'=> Auth::user()->id,
'change_holder'=> $u_p->user_id, 
'operation'=> 'reject',
'quantity'=> $u_p->quantity,
'product_id'=> $u_p->product_id
]);
// log end 

$pro = Product::find($u_p->product_id);
$pro->quantity = $pro->quantity+$u_p->quantity;
$pro->save(); 
$u_p->delete();

    });
    return redirect()->back();
   } 

   public function mylogs(){
    $logs = log::get();
$data=compact('logs');
return view('log')->with($data);
   }

}
