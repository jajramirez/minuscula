<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TRD extends Model
{
    protected $table = "SID_TRD";

    public $timestamps = false;
    
	protected $fillable = ['cod_enti', 
							'cod_trd', 
							'arc_gest',  
							'arc_cent', 
							'ban_ct', 
							'ban_e', 
							'ban_m',
							'ban_s',
							'tex_obse',
							'ind_esta',
							'cod_usua',
							'fec_actu',
							'hor_actu',
							'cod_orga',
							'cod_ccd'
							];
}
