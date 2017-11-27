<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE_DETA_ARCH extends Model
{
    protected $table = "SID_EXPE_DETA_ARCH";

    public $timestamps = false;
    
	protected $fillable = ['cod_expe', 
							'num_regi', 
							'num_arch',  
							'nom_arch', 
							'fec_arch', 
							'num_pagi', 
							'num_tama',
							'nom_soft',
							'nom_vers',
							'nom_reso',
							'nom_idio'
							];
}
