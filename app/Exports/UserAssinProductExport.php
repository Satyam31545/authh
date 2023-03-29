<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserAssinProductExport implements FromView
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('excel.export', ['data' => Employee::get(['id','name'])->load(['products:id,name,prize'])]);
    }

}
