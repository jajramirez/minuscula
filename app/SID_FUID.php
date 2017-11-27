<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_FUID extends Model
{
    protected $table = "SIS_FUID";

    public $timestamps = false;
    
	protected $fillable = ['cod_enti', 
							'cod_trd', 
							'num_regi', 
							'nom_asun', 
							'num_docu', 
							'fec_inic', 
							'fec_fina', 
							'num_carp', 
							'num_tomo',
							'num_caja',
							'num_inte',
							'num_foli',
							'ban_digi',
							'fre_cons',
							'nom_digi',
							'nom_arch',
							'fec_crea',
							'num_pagi',
							'tam_arch',
							'sof_capt',
							'ver_arch',
							'res_arch',
							'idi_arch',
							'ent_arch',
							'obs_gen1',
							'obs_gen2',
							'obs_gen3',
							'obs_gen4',
							'cod_ccd',
							'cod_orga',
							'cod_bode',
							'gen_sopo',
							'num_orde',
						];


	public function scopeSearch($query, $num_regi)
	{
		return $query->where('num_regi', 'LIKE', "%$num_regi%");
	}

}
