<?php

namespace App\Console\Commands;
use Excel;
use App\Exports\UserAssinProductExport;
use Mail;

use Illuminate\Console\Command;

class EmployeesProductExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Export:EmployeesProduct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To export Employees Product through excel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time= time();
        Excel::store(new UserAssinProductExport,$time.'.xlsx');
              $data=['time'=>date('Y:m:d H:i:s',$time)];
       Mail::send('excel.mail', $data, function ($message) use($time){
           $message->to('satyamssingh9455@gmail.com', 'satyam mail');
           $message->subject('Employees product details');
           $message->attach(storage_path('app/'.$time.'.xlsx'));

       });  
       }
}
