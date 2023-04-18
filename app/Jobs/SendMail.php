<?php

namespace App\Jobs;

use Excel;
use Illuminate\Bus\Queueable;
use App\Models\UserAssinProduct;
use Mail;
use Illuminate\Queue\SerializesModels;
use App\Exports\UserAssinProductExport;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->time=$time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data=  UserAssinProduct::get();
        $employee=$data->unique('employee_id')->count();
        $product=$data->unique('product_id')->count();
        $quantity=$data->sum('quantity');   
        $time= time();
        Excel::store(new UserAssinProductExport,"employeesProduct".$time.'.xlsx');
                       $data=['time'=>$time,'employee'=>$employee,'product'=>$product,'quantity'=>$quantity];
                Mail::send('excel.mail', $data, function ($message)use($time) {
                    $message->to('satyamssingh9455@gmail.com', 'satyam mail');
                    $message->subject('ogo');
                    $message->attach(storage_path('app/employeesProduct'.$time.'.xlsx'));
        
                }); 
    }
}
