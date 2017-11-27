<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD_META;
use App\SID_CCD;
use App\SID_ENTI;
use App\SID_FUID;

class MEtaController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
           
    	 	$ccd = DB::table('SID_CCD_META')
                ->select('SID_CCD_META.cod_enti', 'SID_CCD_META.num_regi', 'SID_CCD_META.met1'
                            , 'SID_CCD_META.met2'
                            , 'SID_CCD_META.met3'
                            , 'SID_CCD_META.met4'
                            , 'SID_CCD_META.met5'
                            , 'SID_CCD_META.met6'
                            , 'SID_CCD_META.met7'
                            , 'SID_CCD_META.met8'
                            , 'SID_CCD_META.met9'
                            , 'SID_CCD_META.met10'
                            , 'SID_CCD_META.met11'
                            , 'SID_CCD.cod_seri'
                            , 'SID_CCD.cod_subs')
            ->join('SID_CCD', 'SID_CCD.num_regi', '=', 'SID_CCD_META.num_regi')
            ->get();

           return view('meta.index')
       		->with('ccds', $ccd);
    }

    public function create(Request $request)
    {
        $data = explode('_', $request->d);

    	$seri = SID_SERI::all();
    	$ccd = SID_CCD::all();

        $subserie = DB::table('SID_CCD')
            ->where('cod_enti', '=', $data[0])
            ->where('num_regi', '=', $data[1])
            ->get();



           return view('meta.create')
            ->with('seris', $seri)
            ->with('ccds', $ccd)
            ->with('subserie', $subserie[0]);
    }

    public function store(Request $request)
    {   
        $respuesta=null;
       
        $ccd = DB::table('SID_CCD')
            ->where('cod_seri', '=', $request->cod_seri)
            ->where('cod_subs', '=', $request->cod_subs)
            ->get();

        $serir = $ccd[0]->num_regi;

        

        $meta = DB::table('SID_CCD_META')
            ->where('num_regi', '=', $serir)
            ->get();


        if(count($meta)==0)
        {
            DB::beginTransaction();
            try {
                $seri = SID_CCD_META::create([
                        'cod_enti'=> '01',
                        'num_regi'=> $serir,
                        'met1'=> $request->met1,
                        'met2'=> $request->met2,
                        'met3'=> $request->met3,
                        'met4'=> $request->met4,
                        'met5'=> $request->met5,
                        'met6'=> $request->met6,
                        'met7'=> $request->met7,
                        'met8'=> $request->met8,
                        'met9'=> $request->met9,
                        'met10'=> $request->met10,
                        'met11'=> $request->met11,
                        ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('meta.create');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('meta.index');
            }
        }
        else
        {
            Flash::warning("Ya existe un registro para la serie y la subserie ingresada.");
            return redirect()->route('meta.create');
        }

    }


    public function destroy($id)
    {
        $seri = SID_CCD_META::where('num_regi', '=', $id)
            ->where('cod_enti', '=', '01')
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('meta.index');
        

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        if(count($data) == 3)
        {
             $val = SID_CCD::where('cod_seri',  $data[2])
                ->get();

            if(count($val) == 0) 
            {

                $max = DB::table('SID_CCD')
                ->select(DB::raw('max(num_regi) as max'))
                ->get();
            
                $num_regi = $max[0]->max + 1;
                DB::beginTransaction();
                date_default_timezone_set('America/Bogota');
                $cod_usua = \Auth::user()->cod_usua;
                $fec_actu = strftime( "%Y-%m-%d", time() );
                $hor_actu = strftime( "%H:%M:%S", time() );

                try {
                    $seri = SID_CCD::create([
                            'cod_enti'=> '01',
                            'num_regi'=> $num_regi,
                            'cod_seri'=> $data[2],
                            'ind_esta'=> 'A',
                            'cod_usua'=> $cod_usua,
                            'fec_actu'=> $fec_actu,
                            'hor_actu'=> $hor_actu,
                            ]);

                    DB::commit();
                   
                } catch(\Illuminate\Database\QueryException $ex){ 
                    DB::rollback();
                    $respuesta = $ex->getMessage(); 
                }

                $data[1] = $num_regi;
            }
            else
            {   
                $data[1] = $val[0]->num_regi;
            }

        }
            
        $ccdF = SID_CCD::where('num_regi',  $data[1] )
                ->get();


            $ccd = DB::table('SID_CCD_META')
                ->where('num_regi', '=', $data[1])
                ->where('cod_enti', '=', $data[0])
                ->get();

            $res = null;

            if(count($ccd) > 0)
            {
                $res = $ccd[0];
            }
        
            $seri = SID_SERI::all();
            $ccdo = SID_CCD::all();
            return view('meta.edit')
                ->with('ccd', $res)
                ->with('ccdf', $ccdF[0])
                ->with('ccdo', $ccdo)
                ->with('seris', $seri)
                ->with('proces');
        

    }


    public function actualizar(Request $request)
    {

             $seri = SID_CCD_META::where('num_regi', '=', $request->num_regi)
                ->where('cod_enti', '=', '01')
                ->get();

            if(count($seri) == 0 )
            {
                $seri = SID_CCD_META::create([
                        'cod_enti'=> '01',
                        'num_regi'=> $request->num_regi,
                        'met1'=> $request->met1,
                        'met2'=> $request->met2,
                        'met3'=> $request->met3,
                        'met4'=> $request->met4,
                        'met5'=> $request->met5,
                        'met6'=> $request->met6,
                        'met7'=> $request->met7,
                        'met8'=> $request->met8,
                        'met9'=> $request->met9,
                        'met10'=> $request->met10,
                        'met11'=> $request->met11,
                        ]);

                DB::commit();

                 Flash::success("Se registró correctamente el registro");
                return redirect()->route('ccd.index');
            }
            else
            {
           
                $seri = SID_CCD_META::where('num_regi', '=', $request->num_regi)
                    ->where('cod_enti', '=', '01')
                    ->update(['met1' => $request->met1,
                            'met2' => $request->met2,
                            'met3' => $request->met3,
                            'met4' => $request->met4,
                            'met5' => $request->met5,
                            'met6' => $request->met6,
                            'met7' => $request->met7,
                            'met8' => $request->met8,
                            'met9' => $request->met9,
                            'met10' => $request->met10,
                            'met11' => $request->met11]);

                Flash::success("Se actualizó correctamente el registro");
                return redirect()->route('seris.index');
            }
        

    }

    public function update(Request $request, $id)
    {

    }   

    public function subserie(Request $request)
    {

        $ccd = SID_CCD::where('cod_seri', '=', $request->cod_seri)
                ->get(); 
        if(count($ccd) == 0)
        {
            return redirect()->route('meta.edit', array('cod_enti' => '01_0_'.$request->cod_seri));
        }
        else
        {
            if(count($ccd) == 1)
            {
                if($ccd[0]->cod_subs == null || $ccd[0]->cod_subs == '0')
                {
                    return redirect()->route('meta.edit', array('cod_enti' => $ccd[0]->cod_enti.'_'.$ccd[0]->num_regi ));
            
                }
     
            }
            else
            {

            return view('meta.subserie')
                ->with('ccds', $ccd);
            }
        }
    }  

    public function seleccion(Request $request)
    {
        return redirect()->route('meta.edit', array('cod_enti' => $request->cod_subs ));
    } 



}
