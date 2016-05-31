<?php namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;

class TranslationQueueService
{
    /**
     * upload and import excel file
     * @param  file $file excel file
     * @return array       status, content excel file
     */
    public function uploadExcel ($file)
    {
        $status = 1;
        if ($file->isValid()) {
            $destinationPath = 'uploads/translation'; 
            $extension = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;
            $file->move($destinationPath, $fileName);
        } else {
            $status = 0;
        }

        if($status) {
            $file = 'uploads/translation/'.$fileName;
            $excel = Excel::load($file)->first()->toArray();            
        }
        return ['status' => $status,'translation' => $excel];
    }
    public function exportExcel($data)
    {
        Excel::create('Document', function($excel)use($data)  {
            $excel->sheet('Sheet', function($sheet) use($data) {

                $sheet -> setCellValue('A1', 'meta');
                $sheet -> setCellValue('B1', 'title');
                $sheet -> setCellValue('C1', 'heading');
                $sheet -> setCellValue('D1', 'subheading');
                $sheet -> setCellValue('E1', 'description');

                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })->export('xls');
    }
}