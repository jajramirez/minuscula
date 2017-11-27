<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_ORGA extends Model
{
    protected $table = "SID_ORGA";

    public $timestamps = false;


	protected $fillable = ['cod_enti', 
							'cod_orga', 
							'nom_orga', 
							'cod_nive', 
							'ind_esta', 
							'cod_padr', 
							'cod_usua', 
							'fec_actu', 
							'hor_actu'
							];
}
