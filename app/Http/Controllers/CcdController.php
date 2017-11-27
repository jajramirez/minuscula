<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD;
use App\SID_ENTI;
use App\SID_FUID;

class CcdController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	
    	 	$ccd = DB::table('SID_CCD')
            ->select('cod_enti', 'num_regi', 'cod_seri', 'cod_subs', 'nom_subs', 'ind_esta', 'cod_usua', 'fec_actu', 'hor_actu')
            ->where('cod_subs', 'like', "%$request->cod_subs%")
            ->get();

           return view('ccd.index')
       		->with('ccds', $ccd);
    }

    public function create()
    {
    	$seri = SID_SERI::all();
    	$enti = SID_ENTI::all();
           return view('ccd.create')
       		->with('seris', $seri)
       		->with('entis', $enti);
    }

    public function store(Request $request)
    {   
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $cod_usua = \Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $max = $ccd = DB::table('SID_CCD')
            ->select(DB::raw('max(num_regi) as max'))
            ->get();
        
        $serir = $max[0]->max + 1;

        $ccd = DB::table('SID_CCD')
            ->where('cod_seri', '=', $request->cod_seri)
            ->where('cod_subs', '=', $request->cod_subs)
            ->get();


        if(count($ccd)==0)
        {

            try {
                $seri = SID_CCD::create([
                        'cod_enti'=> '01',
                        'num_regi'=> $serir,
                        'cod_seri'=> $request->cod_seri,
                        'cod_subs'=> $request->cod_subs,
                        'ind_esta'=> $request->ind_esta,
                        'cod_usua'=> $cod_usua,
                        'fec_actu'=> $fec_actu,
                        'hor_actu'=> $hor_actu,
                        'nom_subs'=> $request->nom_subs
                        ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('ccd.create');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('ccd.index');
            }
        }
        else
        {
            Flash::warning("Ya existe un registro para la serie y la subserie ingresada.");
            return redirect()->route('ccd.create');
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
        $serid1 = SID_CCD::where('num_regi', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->get();
        foreach ($serid1 as $serid) {
           $ccd = $serid->cod_seri.'.'.$serid->cod_subs;
        }

        $fuid = SID_FUID::where('cod_ccd', '=', $ccd)->get();
        
        if(count($fuid)>0)
        {
            Flash::success("No se puede eliminar un registro en uso FUID");
            return redirect()->route('ccd.index');
        }
        else
        {
              $seri = SID_CCD::where('num_regi', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('ccd.index');
        }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccdF = SID_CCD::where('cod_enti',  $data[0] );
        $ccd = DB::table('SID_CCD')
            ->select('cod_enti', 'num_regi', 'cod_seri', 'cod_subs', 'nom_subs', 'ind_esta', 'cod_usua', 'fec_actu', 'hor_actu')
            ->where('num_regi', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->get();
        $seri = SID_SERI::all();
        return view('ccd.edit')
            ->with('ccd', $ccd[0])
            ->with('ccdf', $ccdF)
            ->with('seris', $seri);
    }


    public function actualizar(Request $request)
    {
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );

        $ccd = DB::table('SID_CCD')
            ->where('cod_seri', '=', $request->cod_seri)
            ->where('cod_subs', '=', $request->cod_subs)
            ->where('num_regi', '<>', $request->num_regi)
            ->get();

        if(count($ccd) == 0)
        {
           
            $seri = SID_CCD::where('num_regi', '=', $request->num_regi)
                ->where('cod_enti', '=', $request->cod_enti)
                ->update(['cod_seri' => $request->cod_seri,'cod_subs'=>$request->cod_subs, 'nom_subs'=> $request->nom_subs, 'ind_esta'=> $request->ind_esta,'cod_usua'=> $cod_usua,
                'fec_actu'=> $fec_actu, 'hor_actu'=> $hor_actu]);

            Flash::warning("Se actualizó correctamente el registro");
            return redirect()->route('ccd.index');
        }
        else
        {
            
            Flash::warning("No se puede actualizar el registro, la serie ". $request->cod_seri . " y la subserie ".$request->cod_subs. " existe para otro registro   ") ;
            return redirect()->route('ccd.index');
        }
    }

    public function update(Request $request, $id)
    {

    }      



}
