<?php

namespace Modules\Admin\Http\Exports;

use Modules\Admin\Models\Package;
use Modules\Admin\Models\Offer;
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


class OfferExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $package_id,$status;

    function __construct($package_id,$status) {
            $this->status = $status;
            $this->package_id = $package_id;
    }

    public function collection()
    {
        $offer = Offer::with('package')->orderBy('id', 'desc');

        if($this->status!='All')
        {
            $offer = $offer->where('status',$this->status);
        }
        if($this->package_id!='All')
        {
            $offer = $offer->where('package_id',$this->package_id);
        }

            return $offer->get();
    }

    public function map($offer): array
    {


        $offer_arry =array(
            ucfirst($offer->offername),
            ucfirst($offer->package->name),
            $offer->price,
            $offer->extent_expiry_days,
            ($offer->status == 1) ? "Active" : "In Active",
            $offer->created_at,
            $offer->updated_at,
        );

        return[
            $offer_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Offer Name',
        'Package Name',
        'Price',
        'Extend Expiry In days',
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
   
                $event->sheet->getDelegate()->getStyle('A1:G1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

}