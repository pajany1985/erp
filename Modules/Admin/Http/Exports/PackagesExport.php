<?php

namespace Modules\Admin\Http\Exports;

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


class PackagesExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $status;

    function __construct($status) {
            $this->status = $status;
    }

    public function collection()
    {
        $packages = Package::orderBy('id', 'desc');

        if($this->status!='All')
        {
            $packages = $packages->where('status',$this->status);
        }

            return $packages->get();
    }

    public function map($package): array
    {


        $package_arry =array(
            ucfirst($package->name),
            $package->cost,
            $package->expiry_in_days,
            ($package->status == 1) ? "Active" : "In Active",
            $package->created_at,
            $package->updated_at,
        );

        return[
            $package_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Package Name',
        'Price',
        'Expiry In days',
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
   
                $event->sheet->getDelegate()->getStyle('A1:F1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

}