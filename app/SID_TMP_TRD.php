<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TMP_TRD extends Model
{
    protected $table = "SID_TMP_TRD";

    public $timestamps = false;
    
	protected $fillable = ['id', 
							'trd_tmp1',
							'trd_tmp2', 
							'trd_tmp3', 
							'trd_tmp4', 
							'trd_tmp5', 
							'trd_tmp6', 
							'trd_tmp7', 
							'trd_tmp8', 
							'trd_tmp9', 
							'trd_tmp10', 
							'cod_usua'
							];
}
