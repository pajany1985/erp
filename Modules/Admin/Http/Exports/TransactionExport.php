<?php

namespace Modules\Admin\Http\Exports;

use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Transaction;
use Modules\Admin\Models\Position;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Session;
use Carbon\Carbon;
use DB;


class TransactionExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $package_id,$status;

    function __construct($package_id,$status) {
            $this->package_id = $package_id;
            $this->status = $status;
    }

    public function collection()
    {
        $transaction = Transaction::with('employer','package')->orderBy('id', 'desc');
        if($this->package_id!='All')
        {
            $transaction = $transaction->where('package_id',$this->package_id);
        }

        if($this->status!='All')
        {
            $transaction = $transaction->where('status',$this->status);
        }

    
            return $transaction->take(1000)->get();
    }

    public function map($transaction): array
    {


        $transaction_arry =array(
            ucfirst($transaction->employer->first_name).' '.ucfirst($transaction->employer->last_name),
            $transaction->employer->email,
            ucfirst($transaction->package->name),
            $transaction->transaction_id,
            $transaction->amount,
            $transaction->paid_date,
            ($transaction->status == 1) ? "Success" : "Failure",
            $transaction->created_at,
            $transaction->updated_at,
        );

        return[
            $transaction_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Employer Name',
        'Email',
        'Package Name',
        'Transaction Id',
        'Amount',
        'Paid Date',
        'Status',
        'Created Date',
        'Updated Date',);
        return[
            $heading_arry
        ];
    }
  
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:K1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

}