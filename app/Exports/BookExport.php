<?php 

namespace App\Exports;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
class BookExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithTitle
{
     /**
    * @return \Illuminate\Support\Collection
    */
  
    use Exportable;

   
    public function startCell(): string
    {
        return 'A2';
    }

    public function query()
    {
      
         $query = Book::all();
         return $query;
    }
    
    public function map($query): array
    {

     
        return [
            $query->book_name,
            $query->author,
            $query->book_cover,
        ];
    
        
    }

    public function headings(): array
    {
        return [
            'A1'=>'Book Name',
            'B1'=>'Author',
            'C1'=>'Book Cover',
        ];
    }

 

    public function title(): string
    {
        return 'BookList';
    }
}