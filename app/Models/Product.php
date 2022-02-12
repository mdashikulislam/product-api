<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','mpn','asin','barcode','category','manufacturer','brand','color','gender','material',
        'size','length','width','height','weight','contributors','ingredients',
        'release_date','description','features',
        'images','stores','reviews'];
}
