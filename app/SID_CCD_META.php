<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_CCD_META extends Model
{
    protected $table = "SID_CCD_META";

    public $timestamps = false;

	protected $fillable = ['cod_enti', 'num_regi', 'met1'
							, 'met2'
							, 'met3'
							, 'met4'
							, 'met5'
							, 'met6'
							, 'met7'
							, 'met8'
							, 'met9'
							, 'met10'
							, 'met11'];
}
