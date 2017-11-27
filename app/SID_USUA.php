<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SID_USUA extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    
    protected $table = "SID_USUA";
   
    protected $fillable = [
        'cod_usua', 'con_usua', 'nom_usua','ind_esta', 'cod_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'con_usua',
    ];

    public function administrador()
    {
        return $this->cod_role === 1;
    }
    public function operario()
    {
        return $this->cod_role === 2;
    }
    public function consulta()
    {
        return $this->cod_role === 3;
    }


}
