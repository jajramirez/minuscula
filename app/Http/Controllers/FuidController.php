<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_ENTI;
use App\SID_ORGA;
use App\SID_FUID;
use App\SID_CCD;
use MBarryvdh\DomPDF\Facade;

class FuidController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

     //
    public function index(Request $request)
    {
        $url=$request->documento;
        return view('fuid.documento')
            ->with('url', $url);
    }
    

    public function create(Request $request)
    {   

        $orgas = SID_ORGA::all();
        $ccds = SID_CCD::all();
        $seris = SID_SERI::all();

        return view('fuid.create')
            ->with('busqueda', $request->busqueda)
            ->with('orgas', $orgas)
            ->with('ccds', $ccds)
            ->with('seris', $seris);
    }   

    public function store(Request $request)
    {
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $fechai = null;
        $fechaf = null;
        if($request->fec_inic != null)
        {
            $fechai = substr($request->fec_inic,6,4) .'-'.substr($request->fec_inic,0,2) .'-'. substr($request->fec_inic,3,2) ;
        }
        if($request->fec_fina != null)
        {
            $fechaf = substr($request->fec_fina,6,4) .'-'.substr($request->fec_fina,0,2) .'-'. substr($request->fec_fina,3,2) ;
        }
        $name = null;
        if($request->file('nom_arch'))
        {
            $file = $request->file('nom_arch');
            $name = 'expdiente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);
        }
        
        $codorga = null;
        $codccd = null;
        if($request->cod_subs != null)
        {
            $codorga = $request->cod_orga .'.'. $request->cod_seri . '.'.$request->cod_subs;
            $codccd =  $request->cod_seri . '.'.$request->cod_subs;
        }
        else
        {
            $codorga =  $request->cod_orga .'.'. $request->cod_seri ;
            $codccd = $request->cod_seri ;
        }

        try {

            $max = DB::table('SIS_FUID')
                ->select(DB::raw('max(num_regi) as max'))
                ->get();


                
            $num_regi = $max[0]->max + 1;


            $seri = SID_FUID::create([

                    'cod_enti'=> '01' ,
                    'num_regi'=> $num_regi,
                    'cod_trd' => $codorga,
                    'cod_orga'=> $request->cod_orga,
                    'cod_ccd' => $codccd,
                    'fec_inic' => $fechai,
                    'fec_fina' => $fechaf,
                    'num_caja' => $request->num_caja,
                    'num_carp' => $request->num_carp,
                    'num_tomo' => $request->num_tomo,
                    'num_inte' => $request->num_inte,
                    'num_foli' => $request->num_foli,
                    'obs_gen1' => $request->obs_gen1,
                    'fre_cons' => $request->fre_cons,
                    'nom_arch' => $name,
                    'nom_asun' => $request->nom_asun,
                    'cod_bode' => $request->cod_bode,
                    'gen_sopo' => $request->gen_sopo,
                    'num_orde' => $num_regi]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('home.fuid');
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('home.fuid');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);  
        $seri = SID_FUID::where('cod_enti', '=', $data[0])
            ->where('cod_trd', '=', $data[1])
            ->where('num_regi', '=', $data[2])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('home.fuid');
	 
    }

    public function edit($id)
    {   
        $data = explode('_', $id);          
        $seri = DB::table('SIS_FUID')
            ->where('cod_enti', '=', $data[0])
            ->where('cod_trd', '=', $data[1])
            ->where('num_regi', '=', $data[2])
            ->get();
        $res = $seri->toArray();
        $resultado = $res[0];
        $resultado->fec_fina = substr($resultado->fec_fina,5,2) .'/'.substr($resultado->fec_fina,8,2) .'/'. substr($resultado->fec_fina,0,4) ;
        $resultado->fec_inic= substr($resultado->fec_inic,5,2) .'/'.substr($resultado->fec_inic,8,2) .'/'. substr($resultado->fec_inic,0,4) ;

        //$codigos = explode(".",$$resultado->cod_ccd);
     
        $orgas = SID_ORGA::all();
        $ccds = SID_CCD::all();
        $seris = SID_SERI::all();

        return view('fuid.edit')
            ->with('fuid', $res[0])
            ->with('orgas', $orgas)
            ->with('ccds', $ccds)
            ->with('seris', $seris);;
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


        $respuesta=null;
        DB::beginTransaction();

        try {

            date_default_timezone_set('America/Bogota');
            $cod_usua = Auth::user()->cod_usua;
            $fec_actu = strftime( "%Y-%m-%d", time() );
            $hor_actu = strftime( "%H:%M:%S", time() );
            $fechai = substr($request->fec_inic,6,4) .'-'.substr($request->fec_inic,0,2) .'-'. substr($request->fec_inic,3,2) ;
            $fechaf = substr($request->fec_fina,6,4) .'-'.substr($request->fec_fina,0,2) .'-'. substr($request->fec_fina,3,2) ;
       
            $seri = SID_FUID::where('cod_enti', '=', $request->cod_enti)
                ->where('cod_trd', '=', $request->cod_trd)
                ->where('num_regi', '=', $request->num_regi)
                ->update([
                        'fec_inic' => $fechai,
                        'fec_fina' => $fechaf,
                        'num_caja' => $request->num_caja,
                        'num_carp' => $request->num_carp,
                        'num_tomo' => $request->num_tomo,
                        'num_inte' => $request->num_inte,
                        'num_foli' => $request->num_foli,
                        'obs_gen1' => $request->obs_gen1,
                        'fre_cons' => $request->fre_cons,
                        'nom_arch' => $request->nom_arch,
                        'nom_asun' => $request->nom_asun,
                        'cod_bode' => $request->cod_bode,
                        'gen_sopo' => $request->gen_sopo]);
                

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('home.fuid');
        }
        else
        {
            Flash::success("Se actulizo correctamente el registro");
            return redirect()->route('home.fuid');
        }
    }

    public function update(Request $request, $id)
    {

    }    

    public function  etiquetas(Request $requesst)
    {
        return view('fuid.etiquetas');
    }  

    public function pdf(Request $request)
    {

	date_default_timezone_set('America/Bogota');
    $fec_actu = strftime( "%Y-%m-%d", time() );
    $name  = null;  

    $coun = strlen($request->cod_bode);
    if($coun > 0)
    {
        $fuid = DB::table('V_SIS_FUID')
            ->where('V_SIS_FUID.cod_bode', '=', $request->cod_bode)
            ->join('SID_ORGA', 'V_SIS_FUID.cod_orga', '=', 'SID_ORGA.cod_orga')
            ->select('V_SIS_FUID.*', 'SID_ORGA.nom_orga')
            ->get();

        $view =  \View::make('pdf.etiquetas', compact('fuid', 'fec_actu'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $name = time();
        $filename =  public_path() ."/documentos/etiquetas". $name. ".pdf";
        file_put_contents($filename, $pdf->stream('etiquetas'));
        

    }
    else
    {
         $fuid = DB::table('V_SIS_FUID')
            ->where('V_SIS_FUID.cod_trd', '=', $request->cod_trd)
            ->where('V_SIS_FUID.cod_enti', '=', $request->cod_enti)
            ->where('V_SIS_FUID.num_regi', '=', $request->NUN_REGI)
            ->join('SID_ORGA', 'V_SIS_FUID.cod_orga', '=', 'SID_ORGA.cod_orga')
            ->select('V_SIS_FUID.*', 'SID_ORGA.nom_orga')
            ->get();

        $f = $fuid[0];

        $view =  \View::make('pdf.etiquetasfuid', compact('f', 'fec_actu'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $name = time();
        $filename =  public_path() ."/documentos/etiquetas". $name. ".pdf";
        file_put_contents($filename, $pdf->stream('etiquetas'));

    }

    return $name;
    
        
    }

    public function datos(Request $request)
    {
        $fuid = DB::table('V_SIS_FUID')
        ->where('V_SIS_FUID.cod_bode', '=', $request->cod_bode)
            ->join('SID_ORGA', 'V_SIS_FUID.cod_orga', '=', 'SID_ORGA.cod_orga')
            ->select('V_SIS_FUID.*', 'SID_ORGA.nom_orga')
            ->get();

        return json_encode($fuid);
    }
}
