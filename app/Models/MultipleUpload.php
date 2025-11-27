<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleUpload extends Model
{
    use HasFactory;

    // Migration creates table named `multipleuploads` (no underscore).
    // Keep table name in sync with migrations.
    protected $table = 'multipleuploads';

    protected $fillable = [
        'filename',
        'ref_table',
        'ref_id',
    ];
}
