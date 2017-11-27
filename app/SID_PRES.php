<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sid_pres  extends Model
{
    protected $table = "SID_PRES";

    public $timestamps = false;


	protected $fillable = ['sid_pres', 'fec_entr','sid_ofci', 'nom_soli', 'des_sopo', 'cod_usua', 'fec_actu', 'hor_actu'];
}


