<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TRD_DETA extends Model
{
    protected $table = "SID_TRD_DETA";

    public $timestamps = false;
    
	protected $fillable = ['cod_enti', 
							'cod_trd', 
							'num_regi',  
							'nom_desc',
							'cod_usua',
							'fec_actu',
							'hor_actu'
							];
}
