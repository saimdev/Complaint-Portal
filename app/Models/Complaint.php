<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Complaint extends Model
{
    use Sortable;
    use HasFactory;
    public $sortable = ['id', 'name', 'registration', 'department'];
}
