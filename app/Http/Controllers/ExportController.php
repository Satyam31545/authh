<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Models\UserAssignProduct;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function excel_export(Request $request)
    {
        $data = $request['data'];
        return (new LogsExport($request['data']))->download('app.xlsx');

    }
// for pdf
    public function fpdf()
    {

        $id = Auth::user();
        $employee = $id->employees()->first();
        $products = UserAssignProduct::where("user_id", $id->id)->with("products")->get();

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
            $pdf->Cell(40, 6, $product->products->name, 0, 0);
            $pdf->Cell(50, 6, $product->products->description, 0, 0);
            $pdf->Cell(30, 6, $product->products->quantity, 0, 0);
            $pdf->Cell(20, 6, $product->products->prize, 0, 0);
            $pdf->Cell(15, 6, $product->products->tax, 0, 0);
            $a = ($product->products->quantity * $product->products->prize);
            $a += ($product->products->quantity * $product->products->prize) * ($product->products->tax / 100);
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
