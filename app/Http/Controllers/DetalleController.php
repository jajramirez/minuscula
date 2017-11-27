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
use App\SID_ORGA;
use App\SID_FUID;
use App\SID_EXPE;
use App\SID_EXPE_DETA;
use App\SID_EXPE_DETA_ARCH;

class DetalleController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

    }

     public function expedientes(Request $request)
    {

        $detalles = DB::table('SID_EXPE_DETA')
            ->where('cod_expe', '=', $request->cod_expe)
            ->get();


            $detalleBuscar = $detalles[0];

            $CCDBuscar = DB::table('SID_CCD')
                    ->where('SID_CCD.cod_seri', '=', $detalleBuscar->cod_tipo)
                    ->where('SID_CCD.cod_subs','=', $detalleBuscar->cod_subs)
                    ->distinct()
                    ->get();

    
            if(count($CCDBuscar) > 0 )
            {
                $CCD= $CCDBuscar[0];
                  
                $encabezadosBucar = DB::table('SID_CCD_META')
                        ->where('SID_CCD_META.num_regi', '=', $CCD->num_regi)
                        ->where ('SID_CCD_META.cod_enti', '=', $CCD->cod_enti)
                        ->distinct()
                        -get();

                if(count($encabezadosBucar)>0)
                {        
                    $encabezado = $encabezadosBucar[0];
                }

                else
                {

                    $encabezado = null;
                }

            }
            else
            {
                $encabezado = null;
            }


           return view('detalles.index')
            ->with('detalles', $detalles)
            ->with('cod_expe', $request->cod_expe)
            ->with('encabezado', $encabezado);
    }

    public function nuevo(Request $request)
    {

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
           return view('detalles.create')
            ->with('cod_expe', $request->cod_expe)
            ->with('series', $series)
            ->with('orgas', $orgas)
            ;
    }

    public function store(Request $request)
    {


        $respuesta=null;
        DB::beginTransaction();
        $max = $ccd = DB::table('SID_EXPE_DETA')
            ->select(DB::raw('max(num_regi) as max'))
            ->get();
        
        $num_regi = $max[0]->max + 1;

        try {
            $seri = SID_EXPE_DETA::create([

                    'num_regi'=> $num_regi, 
                    'cod_orga'=> $request->cod_orga, 
                    'cod_tipo'=> $request->cod_seri,  
                    'cod_expe'=> $request->cod_expe, 
                    'anh_fina'=> $request->anh_fina, 
                    'fec_ingr'=> $request->fec_ingr, 
                    'nom_moda'=> $request->nom_moda,
                    'nom_prog'=> $request->nom_prog,
                    'obs_gene'=> $request->obs_gene,
                    'tip_nivel'=> $request->tip_nivel,
                    'cod_subs' => $request->cod_subs
                    ]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('detalles.nuevo', array('cod_expe' => $request->cod_expe));
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('detalles.expediente', array('cod_expe' => $request->cod_expe));
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);


        $fuid = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $data[0])
        ->get();
        
        if(count($fuid)>0)
        {
            Flash::success("No se puede eliminar un registro con archivos");
            return redirect()->route('detalles.expediente', array('cod_expe' => $data[0]));
        }
        else
        {
            $seri = SID_EXPE::where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[1])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('detalles.expediente', array('cod_expe' => $data[0]));
        }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE_DETA')
            ->where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[1])
            ->get();

         $series = SID_SERI::all();
         $orgas = SID_ORGA::all();
    

        return view('detalles.edit')
            ->with('expe', $ccd[0])
            ->with('series', $series)
            ->with('orgas', $orgas);
    }


    public function actualiza(Request $request)
    {

        $seri = SID_EXPE_DETA::where('cod_expe', '=', $request->cod_expe)
            ->where('num_regi', '=', $request->num_regi)
            ->update(['cod_orga' => $request->cod_orga,'cod_tipo'=>$request->cod_seri, 'nom_prog'=> $request->nom_prog,
                     'nom_moda'=> $request->nom_moda, 'tip_nivel'=> $request->tip_nivel, 'fec_ingr'=> $request->FEC_ING,
                     'anh_fina'=> $request->anh_fina, 'obs_gene'=> $request->obs_gene,'cod_subs' => $request->cod_subs]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('detalles.expediente', array('cod_expe' => $request->cod_expe));
    }

    public function update(Request $request, $id)
    {

    }      



}
