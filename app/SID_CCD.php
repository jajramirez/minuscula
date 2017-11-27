<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_CCD extends Model
{
    protected $table = "SID_CCD";

    public $timestamps = false;

	protected $fillable = ['cod_enti', 'num_regi', 'cod_seri', 'cod_subs', 'nom_subs', 'ind_esta', 'cod_usua', 'fec_actu', 'hor_actu'];
}
