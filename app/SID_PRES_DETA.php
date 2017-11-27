<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sid_pres_DETA extends Model
{
    protected $table = "SID_PRES_DETA";

    public $timestamps = false;


	protected $fillable = ['sid_cod', 'sid_pres', 'cod_trd',
				'sid_caja', 'sid_carp', 'sid_cont', 'sid_tipo', 'sid_obse', 'fec_soli',
				 'fec_entr', 'fec_devo', 'sid_via'
							];
}


