<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE extends Model
{
    protected $table = "SID_EXPE";

    public $timestamps = false;
    
	protected $fillable = ['cod_expe', 
							'num_docu', 
							'tip_docu',  
							'pri_nomb', 
							'seg_nomb', 
							'pri_apel', 
							'seg_apel'
							];
}
