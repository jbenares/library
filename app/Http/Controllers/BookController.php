<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function create(Request $request){
        $validated=$this->validate($request,[
            'book_name'=>['required','string',
                Rule::unique('book_details', 'book_name')->where('author', $request->input('author'))],
            'author'=>['required','string'],
            'book_cover'=>['required'],
        ]);
        $cover = $request->file('book_cover');
        $filename = time()."_".$cover->getClientOriginalName();
        Storage::disk('uploads')->put($filename, file_get_contents($request->file('book_cover')));

       
        Book::create([
            'book_name'=>$request->input('book_name'),
            'author'=>$request->input('author'),
            'book_cover'=>$filename
        ]);
    }

    public function show(Request $request){

        $books = Book::orderBy('book_name','ASC')->get();

        foreach($books AS $b){
            $booksArray[] = [
                'id'=>$b->id,
                $b->book_name,
                $b->author,
            ];
        }

        return response()->json($booksArray);
    }

    public function search(Request $request){

        $filter=$request->get('filter');
       
        if($filter!=null){
            $books=Book::where('book_name','LIKE',"%$filter%")
                            ->orWhere('author','LIKE', "%$filter%")
                            ->orderBy('book_name','ASC')->paginate(10);
            return response()->json($books);
        }else{
            $books = Book::orderBy('book_name','ASC')->paginate(10);
            return response()->json($books);
        }
    }

    public function edit($id){

        $books = Book::where('id','=',$id)->get();
        foreach($books AS $b){
            $formData = [
                'book_name'=>$b->book_name,
                'author'=>$b->author,
                'book_cover'=>$b->book_cover,
            ];
        }
        return response()->json($formData);
    }

    public function update(Request $request, $id){

        $books=Book::where('id',$id)->first();
        $validated=$this->validate($request,[
            'book_name'=>['required','string',
                Rule::unique('book_details', 'book_name')->where('author', $request->input('author')) . $id],
            'author'=>['required','string'],
        ]);

        if($request->file('book_cover')){
            $cover = $request->file('book_cover');
            $filename = time()."_".$cover->getClientOriginalName();
            Storage::disk('uploads')->put($filename, file_get_contents($request->file('book_cover')));

            $books->update([
                'book_name'=>$request->input('book_name'),
                'author'=>$request->input('author'),
                'book_cover'=>$filename
            ]);

        } else {
          
            $books->update([
                'book_name'=>$request->input('book_name'),
                'author'=>$request->input('author')
            ]);
        }

    }

    public function delete(Request $request, $id){

        $filename=Book::where('id',$id)->value('book_cover');

        $books = Book::where('id', $id);
        $books->delete();
        $fileToDelete = 'books/'. $filename;
        unlink($fileToDelete);

    }

    public function export_books(){
        return Excel::download(new BookExport(), 'BookList.xlsx');
    }


}
