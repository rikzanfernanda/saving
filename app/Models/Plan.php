<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model {

    use HasFactory;

    protected $fillable = [
        'id_user', 'bulan', 'tahun', 'id_anggaran', 'jumlah', 'frekuensi', 'satuan', 'total'
    ];

}
