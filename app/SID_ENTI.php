<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_ENTI extends Model
{
    Protected $table = "SID_ENTI";

    public $timestamps = false;

	protected $fillable = ['cod_enti', 'nom_enti', 'nit_enti', 'dir_enti', 'ind_esta'];
}
