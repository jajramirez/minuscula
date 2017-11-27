<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class V_SID_TRD_DETA extends Model
{
    protected $table = "V_SID_TRD2";

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
							'nom_desc'
							];
}
