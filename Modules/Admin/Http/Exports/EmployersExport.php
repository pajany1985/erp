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


class EmployersExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $storagepercent,$package_id,$status,$paymentstatus;

    function __construct($storagepercent,$package_id,$status,$paymentstatus) {
            $this->storagepercent = $storagepercent;
            $this->package_id = $package_id;
            $this->status = $status;
            $this->paymentstatus =$paymentstatus;
    }

    public function collection()
    {
        $employers = Employer::with('package','state','country')->where('master_empid',NULL)->orderBy('id', 'desc');
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
        $employer_arry =array();
        $storagedetails = getstoragelimit($employer->id);
        $from =0;
        $to =100;
        if($this->storagepercent!='All')
        {
            $storagepercent = explode('_',$this->storagepercent);
            $from = $storagepercent[0];
            $to = $storagepercent[1];
        }
        if($storagedetails['used_percentage']>=$from && $storagedetails['used_percentage']<=$to){
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
                    $storagedetails['useddisk_space'].' of '.$storagedetails['totalspace'].' GB used',
                    $storagedetails['diskremaining'].' available',
                    $storagedetails['used_percentage'].'% used out of '.$storagedetails['totalspace'].' GB',
                );
            }
            
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
        'Updated Date',
        'Storage Used Space',
        'Available Space',
        'Storage Used Percentage',);
        return[
            $heading_arry
        ];
    }
  
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:N1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

}