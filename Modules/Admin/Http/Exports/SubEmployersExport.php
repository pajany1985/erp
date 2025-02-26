<?php

namespace Modules\Admin\Http\Exports;

use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Package;
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


class SubEmployersExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $package_id,$status,$paymentstatus;

    function __construct($exportaccountholder_id,$package_id,$status,$paymentstatus) {
            $this->masteremp_id = $exportaccountholder_id;
            $this->package_id = $package_id;
            $this->status = $status;
            $this->paymentstatus =$paymentstatus;
    }

    public function collection()
    {
        $employers = Employer::with('package','state','country')->where('master_empid','!=',NULL)->orderBy('id', 'desc');

        if($this->masteremp_id!='All')
        {
            $employers = $employers->where('master_empid',$this->masteremp_id);
        }

        if($this->package_id!='All')
        {
            $employers = $employers->where('package_id',$this->package_id);
        }

        if($this->status!='All')
        {
            $employers = $employers->where('status',$this->status);
        }

        if($this->paymentstatus!='All')
        {
            $employers = $employers->where('payment_status',$this->paymentstatus);
        }
            return $employers->get();
    }

    public function map($employer): array
    {


        $employer_arry =array(
            ucfirst($employer->first_name).' '.ucfirst($employer->last_name),
            $employer->email,
            ucfirst($employer->package->name),
            $employer->company_name,
            $employer->website,
            $employer->address.' '.$employer->city.', '.$employer->state->state.', '.$employer->country->country.' '.$employer->zip,
            $employer->	phone_no,
            ($employer->payment_status == 1) ? "Approved" : (($employer->payment_status == 2)  ? "Pending" : (($employer->payment_status == 3)  ? "Expired" : "Rejected")),
            ($employer->status == 1) ? "Active" : "In Active",
            $employer->created_at,
            $employer->updated_at,
        );

        return[
            $employer_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Employer Name',
        'Email',
        'Package',
        'Company Name',
        'Website',
        'Address',
        'Phone Number',
        'Payment Status',
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