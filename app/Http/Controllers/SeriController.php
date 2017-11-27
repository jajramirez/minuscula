<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_ENTI;
use App\SID_CCD;

class SeriController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }



     //
    public function index(Request $request)
    {

    	$seris = DB::table('SID_SERI')
            ->select('cod_enti', 'cod_seri', 'nom_seri', 'ind_esta','cod_usua', 'fec_actu', 'hor_actu')
            ->where('nom_seri', 'like', "%$request->cod_seri%")
            ->get();


        return view('seris.index')
       		->with('seris', $seris);
    }
    

    public function create()
    {   
        $enti = SID_ENTI::all();
        return view('seris.create')
            ->with('entis', $enti);;
    }   

    public function store(Request $request)
    {

       
       $enti = DB::table('SID_SERI')
            ->where('cod_seri', '=', $request->cod_seri)
            ->get();

    
       if(count($enti) == 0)
       {
            $respuesta=null;
            DB::beginTransaction();
            date_default_timezone_set('America/Bogota');
            $cod_usua = Auth::user()->cod_usua;
            $fec_actu = strftime( "%Y-%m-%d", time() );
            $hor_actu = strftime( "%H:%M:%S", time() );
            try {
                $seri = SID_SERI::create([
                        'cod_enti'=> '01',
                        'cod_seri'=> $request->cod_seri,
                        'nom_seri'=> $request->nom_seri,
                        'ind_esta'=> $request->ind_esta,
                        'cod_usua'=> $cod_usua,
                        'fec_actu'=> $fec_actu,
                        'hor_actu'=> $hor_actu ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('seris.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('seris.index');
            }

        }
        else
        {
            Flash::warning("El codigo " .$request->cod_seri. " ya existe");
            return redirect()->route('seris.index');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);
        $ccd = SID_CCD::where('cod_seri', '=', $data[1])->get();
	if(count($ccd)>0)
	{
	Flash::success("No se puede elimiar un registro en uso CCD");
        return redirect()->route('seris.index');

	}
	else{

        $seri = SID_SERI::where('cod_seri', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('seris.index');
	}
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $seriF = SID_SERI::where('cod_enti',  $data[0] );
        $seri = DB::table('SID_SERI')
            ->select('cod_enti', 'cod_seri', 'nom_seri', 'ind_esta','cod_usua', 'fec_actu', 'hor_actu')
            ->where('cod_seri', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->get();
        $res = $seri->toArray();
        return view('seris.edit')
            ->with('seri', $res[0])
            ->with('serif', $seriF);
    }


    public function actualizar(Request $request)
    {

        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $seri = SID_SERI::where('cod_seri', '=', $request->cod_seri)
            ->where('cod_enti', '=', $request->cod_enti)
            ->update(['nom_seri' => $request->nom_seri, 'ind_esta'=> $request->ind_esta,'cod_usua'=> $cod_usua,
            'fec_actu'=> $fec_actu, 'hor_actu'=> $hor_actu]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('seris.index');
    }

    public function update(Request $request, $id)
    {

    }   

    public function buscarccd(Request $request)
    {

        echo '<option value="">Seleccione una subserie</option>'; 
        $ccd = SID_CCD::where('cod_seri', '=', $request->cod_seri)->
                where('cod_subs', '<>', null)->get();
        if($ccd != null)
        {
            foreach ($ccd as $c) {
                if($request->cod_subs == $c->cod_subs )
                {
                    if($request->cod_subs != null){
                        echo '<option value="'.$c->cod_subs.'" selected>'.$c->nom_subs.'</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$c->cod_subs.'">'.$c->nom_subs.'</option>';
                }
            }
        }

    }   
}
