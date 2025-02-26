<?php

namespace Modules\Admin\Http\Exports;

use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Candidate;
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


class CandidatesExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $employer_id,$status;

    function __construct($employer_id,$status) {
            $this->employer_id = $employer_id;
            $this->status = $status;
    }

    public function collection()
    {
        $candidates = Candidate::with('employer','position')->orderBy('id', 'desc');
        if($this->employer_id!='All')
        {
            $candidates = $candidates->where('employer_id',$this->employer_id);
        }

        if($this->status!='All')
        {
            $candidates = $candidates->where('status',$this->status);
        }

    
            return $candidates->take(1000)->get();
    }

    public function map($candidate): array
    {


        $candidate_arry =array(
            ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name),
            $candidate->email,
            ucfirst($candidate->position->name),
            ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name),
            ($candidate->status == 1) ? "New" : (($candidate->status == 2)  ? "Inprogress" : "Completed"),
            $candidate->created_at,
            $candidate->updated_at,
        );

        return[
            $candidate_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Candidate Name',
        'Email',
        'Position',
        'Employer Name',
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