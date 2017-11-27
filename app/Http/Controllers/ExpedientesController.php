<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD;
use App\SID_ORGA;
use App\SID_ENTI;
use App\SID_FUID;
use App\SID_EXPE;
use App\SID_EXPE_DETA;
use App\SID_EXPE_DETA_ARCH;

class ExpedientesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $datos = null;
        $encabezado = null;

    	if($request->data == "1")
        {
            $expedientes  = DB::table('V_SID_EXPE');

            if($request->num_docu != null)
            {

                $expedientes->where('V_SID_EXPE.num_docu' , '=',   $request->num_docu);
            }
            if($request->NOM_COM != null)
            {
                $expedientes->where('V_SID_EXPE.NOM_COM' , 'like',   "%$request->NOM_COM%");
            }
            if($request->nom_moda != null)
            {
                $expedientes->where('V_SID_EXPE.nom_moda' , 'like',   "%$request->nom_moda%");
            }
            if($request->nom_prog != null)
            {
                $expedientes->where('V_SID_EXPE.nom_prog' , 'like',   "%$request->nom_prog%");
            }
             if($request->TIP_NIVE != null)
            {
                $expedientes->where('V_SID_EXPE.tip_nivel' , 'like',   "%$request->TIP_NIVE%");
            }
             if($request->nom_arch != null)
            {
                $expedientes->where('V_SID_EXPE.nom_arch' , 'like',   "%$request->nom_arch%");
            }

            if($request->cod_orga != null)
            {
                $expedientes->where('V_SID_EXPE.cod_orga' , '=',   $request->cod_orga);
            }

             if($request->cod_seri != null)
            {
                $expedientes->where('V_SID_EXPE.cod_tipo'  , 'like', "$request->cod_seri%" );
            }

            $datos = $expedientes
            ->join('SID_ORGA', 'V_SID_EXPE.cod_orga', '=', 'SID_ORGA.cod_orga')
            ->select('V_SID_EXPE.*', 'SID_ORGA.PATH')
            ->get();


           if($request->cod_seri != null )
            {


                if(count($datos) > 0 )
                {
                    $CCDBuscar = DB::table('SID_CCD')
                        ->where('SID_CCD.cod_seri', '=', $request->cod_seri)
                        ->where('SID_CCD.cod_subs','=', $request->cod_subs)
                        ->distinct()
                        ->get();

                    $CCD= $CCDBuscar[0];
                    
                    $encabezadosBucar = DB::table('SID_CCD_META')
                        ->where('SID_CCD_META.num_regi', '=', $CCD->num_regi)
                        ->where ('SID_CCD_META.cod_enti', '=', $CCD->cod_enti)
                        ->distinct()
                        ->get();

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

            }
            else
            {   
                $encabezado = null;
            }




        }
        else
        {
            $datos = null;
        }


        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        $subs = SID_CCD::all();

        if($request->cod_seri == null)
        {
            $codseri = null;
        }
        else
        {
            $codseri = $request->cod_seri ;
        }


        if($request->cod_orga == null)
        {
            $codorga = null;
        }
        else
        {
            $codorga = $request->cod_orga ;
        }

        if($request->cod_subs == null)
        {
            $codsubs = null;
        }
        else
        {
            $codsubs = $request->cod_subs ;
        }

        
           return view('expedientes.index')
       		->with('expedientes', $datos)
            ->with('orga', $orga)
            ->with('seri', $seri)
            ->with('subs', $subs)
            ->with('codseri', $codseri)
            ->with('codorga', $codorga)
            ->with('codsubs', $codsubs)
            ->with('encabezado', $encabezado);
    }

    public function create()
    {

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();

        return view('expedientes.create_expe')
            ->with('series', $series)
            ->with('orgas', $orgas);
    }

    public function store(Request $request)
    {
        $name = null;
        $nombre = null;
        if($request->file('nom_arch'))
        {
            $file = $request->file('nom_arch');
            $name = 'expediente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);

           
        }
        

      
        $respuesta=null;
        DB::beginTransaction();
        $max = $ccd = DB::table('SID_EXPE')
            ->select(DB::raw('max(cod_expe) as max'))
            ->get();
        
        $cod_expe = $max[0]->max + 1;

        $max = $ccd = DB::table('SID_EXPE_DETA')
            ->select(DB::raw('max(num_regi) as max'))
            ->get();
        
        $num_regi = $max[0]->max + 1;

        $max = DB::table('SID_EXPE_DETA_ARCH')
            ->select(DB::raw('max(num_arch) as max'))
            ->get();
        
        $num_arch = $max[0]->max + 1;

        $fechai = null;
        $fechaf = null;

        if($request->fec_ingr != null)
        {
            $fechai = substr($request->fec_ingr,6,4) .'-'.substr($request->fec_ingr,0,2) .'-'. substr($request->fec_ingr,3,2) ;
        }
        if($request->fec_arch != null)
        {
            $fechaf = substr($request->fec_arch,6,4) .'-'.substr($request->fec_arch,0,2) .'-'. substr($request->fec_arch,3,2);
        }

        //dd($request);
        try {
            $expe = SID_EXPE::create([

                    'cod_expe'=> $cod_expe, 
                    'num_docu'=> $request->num_docu, 
                    'tip_docu'=> $request->tip_docu,  
                    'pri_nomb'=> $request->pri_nomb, 
                    'seg_nomb'=> $request->seg_nomb, 
                    'pri_apel'=> $request->pri_apel, 
                    'seg_apel'=> $request->seg_apel
                    ]);

            $deta= SID_EXPE_DETA::create([

                    'num_regi'=> $num_regi, 
                    'cod_orga'=> $request->cod_orga, 
                    'cod_tipo'=> $request->cod_seri,  
                    'cod_expe'=> $expe->cod_expe, 
                    'anh_fina'=> $request->anh_fina, 
                    'fec_ingr'=> $fechai, 
                    'nom_moda'=> $request->nom_moda,
                    'nom_prog'=> $request->nom_prog,
                    'obs_gene'=> $request->obs_gene,
                    'tip_nivel'=> $request->tip_nivel,
                    'cod_subs'=> $request->cod_subs
                    ]);

            if($name != null)
            {

                $archivo = SID_EXPE_DETA_ARCH::create([

                        'num_arch'=> $num_arch, 
                        'cod_expe'=> $expe->cod_expe, 
                        'num_regi'=> $deta->num_regi,  
                        'nom_arch'=> $name, 
                        'fec_arch'=> $fechaf, 
                        'num_pagi'=> $request->num_pagi, 
                        'num_tama'=> $request->num_tama,
                        'nom_soft'=> $request->nom_soft,
                        'nom_vers'=> $request->nom_vers,
                        'nom_reso'=> $request->nom_reso,
                        'nom_idio'=> $request->nom_idio,
                        ]);
            }

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('expedientes.create');
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('expedientes.index');
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
        //dd($data);

        $fuid = SID_EXPE_DETA::where('cod_expe', '=', $data[0])
        ->get();

        //dd(count($fuid));
        
        //if(count($fuid)>0)
        //{
        //    Flash::success("No se puede eliminar un registro con detalles");
        //    return redirect()->route('expedientes.index');
        //}
        //else
        //{
            $seri = SID_EXPE::where('cod_expe', '=', $data[0])
            ->where('num_docu', '=', $data[1])
            ->delete();

            $deta = SID_EXPE_DETA::where('cod_expe', '=', $data[0])
            ->delete();

            $arch = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $data[0])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('expedientes.index');
       // }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE')
            ->select(
                'cod_expe', 
                'num_docu', 
                'tip_docu',  
                'pri_nomb', 
                'seg_nomb', 
                'pri_apel', 
                'seg_apel')
            ->where('cod_expe', '=', $data[0])
            ->where('num_docu', '=', $data[1])
            ->get();

        $detalle = DB::table('SID_EXPE_DETA')
            ->where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[2])
            ->get();

        

        $arch = DB::table('SID_EXPE_DETA_ARCH')
            ->where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[2])
            ->where('num_arch', '=', $data[3])
            ->get();




        $data = array('','','','','');
        if($ccd[0]->tip_docu == "CC")
        {
            $data[0] = "selected";
        }
        if($ccd[0]->tip_docu == "CE")
        {
            $data[1] = "selected";
        }
        if($ccd[0]->tip_docu == "RC")
        {
            $data[2] = "selected";
        }
        if($ccd[0]->tip_docu == "TI")
        {
            $data[3] = "selected";
        }
        if($ccd[0]->tip_docu == "NIT")
        {
            $data[4] = "selected";
        }


        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();


        $arraycode = explode('.', $detalle[0]->cod_tipo);

        
        $cod_seris= null;
        $cod_subs = null;

        $encabezado = null;
        if(count($arraycode) == 2)
        {
            $cod_seris= $arraycode[0];
            $cod_subs = $arraycode[1];
           
            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.cod_seri', '=', $arraycode[0])
                ->where('SID_CCD.cod_subs','=', $arraycode[1])
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];
                 
            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.num_regi', '=', $CCD->num_regi)
                ->where ('SID_CCD_META.cod_enti', '=', $CCD->cod_enti)
                ->distinct()
                ->get();

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
            $cod_seris= $arraycode[0];
	       $cod_subs = $detalle[0]->cod_subs;


            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.cod_seri', '=', $cod_seris)
                ->where('SID_CCD.cod_subs','=', $cod_subs)
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];

            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.num_regi', '=', $CCD->num_regi)
                ->where ('SID_CCD_META.cod_enti', '=', $CCD->cod_enti)
                ->distinct()
                ->get();

           if(count($encabezadosBucar)>0)
            {
                $encabezado = $encabezadosBucar[0];
            }
            else
            {
                $encabezado = null;
            }



        }

        return view('expedientes.edit_expe')
            ->with('expe', $ccd[0])
            ->with('detalle', $detalle[0])
            ->with('arch', $arch[0])
            ->with('data', $data)
            ->with('series', $series)
            ->with('orgas', $orgas)
            ->with('enc', $encabezado)
            ->with('codse', $cod_seris)
            ->with('codsu', $cod_subs)
            ;
    }


    public function actualiza(Request $request)
    {

        $name = $request->nombrearchivo;

        if($request->file('nom_arch'))
        {
            $file = $request->file('url_recurso');
            $name = 'expdiente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);
        }


        $respuesta = null;
        DB::beginTransaction();

        try {


            $expe = SID_EXPE::where('cod_expe', '=', $request->cod_expe)
                ->where('num_docu', '=', $request->num_docu)
                ->update(['pri_nomb' => $request->pri_nomb,
                        'seg_nomb'=>$request->seg_nomb, 
                        'pri_apel'=> $request->pri_apel,
                        'seg_apel'=> $request->seg_apel]);


            $deta = SID_EXPE_DETA::where('cod_expe', '=', $request->cod_expe)
                ->where('num_regi', '=', $request->num_regi)
                ->update(['cod_orga' => $request->cod_orga,
                        'cod_tipo'=>$request->cod_seri, 
                        'nom_prog'=> $request->nom_prog,
                        'nom_moda'=> $request->nom_moda, 
                        'tip_nivel'=> $request->tip_nivel, 
                        'fec_ingr'=> $request->FEC_ING,
                        'anh_fina'=> $request->anh_fina, 
                        'obs_gene'=> $request->obs_gene,
                        'cod_subs' => $request->cod_subs]);

	if($request->file('nom_arch'))
        {
            $seri = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $request->cod_expe)
                ->where('num_regi', '=', $request->num_regi)
                ->where('num_arch', '=', $request->num_arch)
                ->update([

                       'cod_expe'=> $request->cod_expe, 
                        'num_regi'=> $request->num_regi,  
                        'nom_arch'=> $name, 
                        'fec_arch'=> $request->fec_arch, 
                        'num_pagi'=> $request->num_pagi, 
                        'num_tama'=> $request->num_tama,
                        'nom_soft'=> $request->nom_soft,
                        'nom_vers'=> $request->nom_vers,
                        'nom_reso'=> $request->nom_reso,
                        'nom_idio'=> $request->nom_idio
                     ]);
	}


            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('expedientes.edit');
        }
        else
        {
            Flash::warning("Se actualizó correctamente el registro");
            return redirect()->route('expedientes.index');
        }
    }

    public function update(Request $request, $id)
    {

    }      

    public function buscarencabezado(Request $request)
    {
           $encabezado = null;
           $cod_seris= $request->cod_seri;
           $cod_subs = $request->cod_subs;


            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.cod_seri', '=', $cod_seris)
                ->where('SID_CCD.cod_subs','=', $cod_subs)
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];

            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.num_regi', '=', $CCD->num_regi)
                ->where ('SID_CCD_META.cod_enti', '=', $CCD->cod_enti)
                ->distinct()
                ->get();

           if(count($encabezadosBucar)>0)
            {
                $encabezado = $encabezadosBucar[0];
            }
            else
            {
                $encabezado = null;
            }
            return json_encode($encabezado);
    }



}
