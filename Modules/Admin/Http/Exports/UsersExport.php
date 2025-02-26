<?php

namespace Modules\Admin\Http\Exports;

use Modules\Admin\Models\User;
use Modules\Admin\Models\Role;
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


class UsersExport implements FromCollection,WithMapping,WithHeadings,WithEvents
{
    protected $role_id,$status;

    function __construct($role_id,$status) {
            $this->role_id = $role_id;
            $this->status = $status;
    }

    public function collection()
    {
        $users = User::with('role')->orderBy('id', 'desc');
        if($this->role_id!='All')
        {
            $users = $users->where('role_id',$this->role_id);
        }

        if($this->status!='All')
        {
            $users = $users->where('status',$this->status);
        }
            return $users->get();
    }

    public function map($user): array
    {
       
        
        $user_arry =array(
            ucfirst($user->name),
            $user->email,
            ucfirst($user->role->name),
            $user->username,
            $user->phone,
            ($user->status == 1) ? "Active" : "In Active",
            $user->created_at,
            $user->updated_at,
        );

        return[
            $user_arry   
        ];
    }

    public function headings(): array
    {
        $heading_arry = array('Name',
        'Email',
        'Role',
        'Username',
        'Phone Number',
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
   
                $event->sheet->getDelegate()->getStyle('A1:H1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

}