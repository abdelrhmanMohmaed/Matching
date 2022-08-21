<?php

namespace App\Exports;

use App\Log;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithHeadings; 

class LogExport implements FromCollection ,WithHeadings
{
    protected $From;
    protected $To;
    public function __construct($From,$To)
    {
        $this->From = $From;
        $this->To = $To;
    }

    public function collection()
    {
        $to=$this->to = Carbon::now()->addDay();
        return Log::select('serial','lnner_part','lnner_qty','customer_part','customer_qty','status','created_at')
        ->WhereBetween('created_at', [$this->From." 00:00:00", $to." 00:00:00"])
        ->orderBy('created_at','DESC')->get() ;
    }
    public function headings(): array
    {
        return[
                'Serial',
                'Lnner Part',
                'Lnner Qty',
                'Customer Part',
                'Customer Qty',
                'Status',
                'Created At', 
        ];
    } 
}
