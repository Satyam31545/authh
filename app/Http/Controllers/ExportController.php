<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Exports\UserAssinProductExport;
use App\Models\UserAssinProduct;
use App\Models\Employee;
use App\Models\Product;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Excel;
use Mail;

class ExportController extends Controller
{
    public function excel_export(Request $request)
    {
        return (new LogsExport($request['data']))->download('app.xlsx');
    }
    public function employee_product_export()
    {

     $data=  UserAssinProduct::get();
$employee=$data->unique('employee_id')->count();
$product=$data->unique('product_id')->count();
$quantity=$data->sum('quantity');   
$time= time();
         Excel::store(new UserAssinProductExport,"employeesProduct".$time.'.xlsx');
               $data=['time'=>$time,'employee'=>$employee,'product'=>$product,'quantity'=>$quantity];
        Mail::send('excel.mail', $data, function ($message) use($time){
            $message->to('satyamssingh9455@gmail.com', 'satyam mail');
            $message->subject('ogo');
            $message->attach(storage_path('app/employeesProduct'.$time.'.xlsx'));

        }); 
        return redirect()->back();

    }


    public function employee_product_download()
    {
       return  Excel::download(new UserAssinProductExport,"employeesProduct.xlsx");
    }
// for pdf 
    public function fpdf()
    {

        $id = Auth::user();
        $employee = $id->employee()->first();
        $products = UserAssinProduct::where("employee_id", $id->id)->get()->load("product");

        $pdf = new Fpdf;
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Image('pica.png', 10, 6, 20, 20);

        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'XYZ company', 0, 1, 'R');

        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'Address', 0, 1, 'R');
        // multiset

        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'city', 0, 1, 'R');

        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'postal', 0, 1, 'R');

        $pdf->Cell(59, 5, '', 0, 1);
        $pdf->Line(10, 35, 200, 35);
        $pdf->Cell(59, 5, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 15);

        $pdf->Cell(89, 5, 'BILL TO :', 0, 0, 'L');
        $pdf->Cell(88, 5, 'INVOICE #', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(89, 5, $employee->name, 0, 0, 'L');
        $pdf->Cell(88, 5, '0000001', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(89, 5, 'Address', 0, 0, 'L');
        $pdf->Cell(88, 5, 'Date', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(89, 5, $employee->address, 0, 0, 'L');
        $pdf->Cell(88, 5, '12/01/12', 0, 1, 'R');
        $pdf->Line(10, 65, 200, 65);

        $pdf->Cell(50, 10, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        /*Heading Of the table*/
        $pdf->Cell(10, 6, 'Sl', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Items', 0, 0, 'C');
        $pdf->Cell(50, 6, 'Description', 0, 0, 'C');
        $pdf->Cell(30, 6, 'Qty', 0, 0, 'C');
        $pdf->Cell(20, 6, 'Price', 0, 0, 'C');
        $pdf->Cell(15, 6, 'Tax', 0, 0, 'C');
        $pdf->Cell(20, 6, 'Amount', 0, 1, 'C'); /*end of line*/
        /*Heading Of the table end*/
        $pdf->SetFont('Arial', '', 10);
        $i = 0;
        $total = 0;
        foreach ($products as $product) {
            ++$i;
            $pdf->Cell(10, 6, $i, 0, 0);
            $pdf->Cell(40, 6, $product->product->name, 0, 0);
            $pdf->Cell(50, 6, $product->product->description, 0, 0);
            $pdf->Cell(30, 6, $product->product->quantity, 0, 0);
            $pdf->Cell(20, 6, $product->product->prize, 0, 0);
            $pdf->Cell(15, 6, $product->product->tax, 0, 0);
            $a = ($product->product->quantity * $product->product->prize);
            $a += ($product->product->quantity * $product->product->prize) * ($product->product->tax / 100);
            $total += $a;
            $pdf->Cell(20, 6, $a, 0, 1, "R");
        }

        $pdf->Line(10, ($i * 6) + 78, 200, ($i * 6) + 78);

        $pdf->Cell(118, 6, '', 0, 1);
        $pdf->Cell(118, 6, '', 0, 0);
        $pdf->Cell(25, 6, 'Subtotal', 0, 0);
        $pdf->Cell(45, 6, $total, 0, 1, 'R');

        $pdf->Output();
        exit;
    }
}
