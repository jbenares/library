<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'document'; 
    protected $fillable = [
        'type_id',
        'unit_id',
        'department_id',
        'user_id',
        'document_date',
        'person_name',
        'subject',
        'keywords',
        'location',
        'room',
        'cabinet',
        'rack',
        'box',
        'folder',
    ];

    public function business_unit(){
        return $this->belongsTo(BusinessUnit::class, 'unit_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function document_type(){
        return $this->belongsTo(DocumentType::class, 'type_id');
    }

}
