<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_SERI extends Model
{
    protected $table = "SID_SERI";

    public $timestamps = false;
    
	protected $fillable = ['cod_enti', 
							'cod_seri', 
							'nom_seri',  
							'ind_esta', 
							'cod_usua', 
							'fec_actu', 
							'hor_actu'
							];
}
