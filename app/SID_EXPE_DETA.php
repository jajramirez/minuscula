<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE_DETA extends Model
{
    protected $table = "SID_EXPE_DETA";

    public $timestamps = false;
    
	protected $fillable = ['cod_expe', 
							'num_regi', 
							'cod_orga',  
							'cod_tipo', 
							'nom_prog', 
							'nom_moda', 
							'tip_nivel',
							'fec_ingr',
							'anh_fina',
							'obs_gene',
							'cod_subs'
							];
}
