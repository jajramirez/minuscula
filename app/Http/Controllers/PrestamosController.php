<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\sid_pres;
use App\sid_pres_DETA;
use App\SID_ORGA;
use App\SID_SERI;
use App\SID_CCD;
use Session;
use MBarryvdh\DomPDF\Facade;

class PrestamosController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        $prestamos = DB::table('sid_pres')
            ->get();

           return view('prestamos.index')
            ->with('prestamos', $prestamos);
    }
    public function create()
    {

    }

    public function prestamo(Request $request)
    {

        $encabezado = null;
        //dd($request);
        $datos = null;
        if($request->proceso == "A")
        {
            date_default_timezone_set('America/Bogota');
            $hor_actu = strftime( "%H:%M:%S", time() );
            Session::put('prestamo', $hor_actu );
            Session::put('datos', null );
            Session::put('encabezado', null );
               
        }
        else
        {


            $datos = Session::get('datos');

            $encabezado = Session::get('encabezado');
            $desc_caja = null;

            if($request->proceso == "D")
            {
                if($request->sid_caja_C == "Completa")
                {   
                    $array= array("cod_bode" => $request->cod_bode,
                              "sid_carp" => "caja Completa",
                              "sid_tipo" => $request->sid_tipo,
                              "fec_soli" => $request->fec_soli,
                              "sid_obse" => $request->sid_obse);

                    $secuencia= array($array);

                    if($datos == null)
                    {
                        $datoscompletos = $secuencia;   
                    }
                    else
                    {
                        $datoscompletos = array_merge($datos, $secuencia);
                    }

                    
                    Session::put('datos', $datoscompletos );
                    $datos = Session::get('datos');

                }
                else
                {

                    $cajas = $request->cajas;
                
                    for($i=0; $i < count($cajas); $i++)
                    {
                        $array[$i] = array("cod_bode" => $request->cod_bode,
                              "sid_carp" => $cajas[$i],
                              "sid_tipo" => $request->sid_tipo,
                              "fec_soli" => $request->fec_soli,
                              "sid_obse" => $request->sid_obse);

                        $secuencia= array($array[$i]);

                       if($datos == null)
                        {
                            if($i == 0)
                            {
                                $datos = $secuencia;
                            } 
                            else
                            {
                                $datoscompletos = array_merge($datos, $secuencia);
                            }
                        }
                        else
                        {
                            $datoscompletos = array_merge($datos, $secuencia);
                            $datos = $datoscompletos;
                         
                        }

                    } 

                    Session::put('datos', $datoscompletos );
                    $datos = Session::get('datos');               
                }
            }

             if($request->proceso == "E")
             {
       
                $datos = Session::get('datos');
                $i = intval($request->item);
                
                unset($datos[$i]);

                $datos[$i]= $array;

                Session::put('datos', $datos );

             }

        }

       return view('prestamos.create')
           ->with('encabezado', $encabezado)
           ->with('datos', $datos);

    }

    public function store(Request $request)
    {   
        

        $respuesta = null;
        $cod_expe = null;
        DB::beginTransaction();
        try {

            date_default_timezone_set('America/Bogota');
            $cod_usua = Auth::user()->cod_usua;
            $fec_actu = strftime( "%Y-%m-%d", time() );
            $hor_actu = strftime( "%H:%M:%S", time() );

            $fecha_solcitud = null;
            $fecha_entrega = null;
            $fecha_devolucion = null;
            
            if($request->fec_entr !=  null )
            {
                $fecha_entrega =  substr($request->fec_entr,6,4) .'-'.substr($request->fec_entr,0,2) .'-'. substr($request->fec_entr,3,2);
            }

            $max = $ccd = DB::table('sid_pres')
            ->select(DB::raw('max(sid_pres) as max'))
            ->get();
        
            $cod_expe = $max[0]->max + 1;

            $prestamo=sid_pres::create([
                'sid_pres'=> $cod_expe, 
                'fec_entr'=> $fecha_entrega,
                'sid_ofci'=> $request->sid_ofci, 
                'nom_soli'=> $request->nom_soli,
                'des_sopo'=> $request->des_sopo, 
                'cod_usua'=> $cod_usua, 
                'fec_actu'=> $fec_actu, 
                'hor_actu'=> $hor_actu
            ]);

            $detalle = json_decode($request->detalle);
            $recorrer = $detalle->myRows;
            for($i = 0; $i < count($recorrer); $i++){
                $fecha_solcitud = null;
                if($recorrer[$i]->fec_soli != null )
                {
                    $fecha_solcitud =  substr($recorrer[$i]->fec_soli,6,4) .'-'.substr($recorrer[$i]->fec_soli,0,2) .'-'. substr($recorrer[$i]->fec_soli,3,2);
                }
                $inserta = sid_pres_DETA::create([
                    'sid_pres'=> $cod_expe, 
                    'sid_caja'=> $recorrer[$i]->sid_caja, 
                    'sid_carp'=> $recorrer[$i]->sid_carp,  
                    'sid_tipo'=> $recorrer[$i]->sid_tipo,
                    'sid_obse'=> $recorrer[$i]->sid_obse, 
                    'fec_soli'=> $fecha_solcitud
                    ]);

            }
            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
         

        if($respuesta ==null)
        {

            $respuesta = "OK";
            $deta = json_decode($request->detalle);
            $recorrer = $deta->myRows;        
            $view =  \View::make('pdf.prestamo', compact('request', 'recorrer', 'cod_expe'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $name = time();
            $filename =  public_path() ."/documentos/prestamo". $name. ".pdf";
            file_put_contents($filename, $pdf->stream('prestamo'));
            //$pdf->download('prestamo.pdf');
            return $name;
        }
        else
        {
            //$respuesta = "error";
        }
       
        echo $respuesta;
    }


    public function destroy($id)
    {

    }

    public function edit($id)
    {   
        $prestamos = DB::table('sid_pres')
            ->where('sid_pres', '=', $id)
            ->get();

        $detalles = DB::table('sid_pres_DETA')
            ->where('sid_pres', '=', $id)
            ->get();

        return view('prestamos.view')
         ->with('prestamos', $prestamos[0])
         ->with('detalles', $detalles);

    }


    public function actualizar(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }  
    public function detalle(Request $request)
    {
        $encabezado = array(   "sid_ofci" => $request->sid_ofci,
                "nom_soli" => $request->nom_soli,
                "des_sopo" => $request->des_sopo,
                "fec_entr" => $request->fec_entr);
        Session::put('encabezado', $encabezado );

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
        return view('prestamos.detalle')
         ->with('series', $series)
         ->with('orgas', $orgas);
    }    

    public function editardetalle(Request $request)
    {
        $i = intval($request->item);
        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
        $datos = Session::get('datos');
        return view('prestamos.edit')
         ->with('series', $series)
         ->with('orgas', $orgas)
         ->with('datos', $datos[$i])
         ->with('item', $request->item);
    }

    public function actualizaritem(Request $request)
    {
         $i = intval($request->item);
         $datos = Session::get('datos');
         unset($datos[$i]);
         //$datos = array_values($datos); 
         Session::put('datos', $datos);
    }

    public function actualizaarray(Request $request)
    {

    }

    public function entrega($id)
    {
        $prestamos = DB::table('sid_pres')
            ->where('sid_pres', '=', $id)
            ->get();

        $detalles = DB::table('sid_pres_DETA')
            ->where('sid_pres', '=', $id)
            ->get();

        return view('prestamos.entrega')
         ->with('prestamos', $prestamos[0])
         ->with('detalles', $detalles)
         ->with('id', $id);
    }

    public function devolver(Request $request)
    {
        $fecha_entrega =  substr($request->FEC_DEV,6,4) .'-'.substr($request->FEC_DEV,0,2) .'-'. substr($request->FEC_DEV,3,2);
        $seri = sid_pres::where('sid_pres', '=', $request->id)
            ->update(['fec_devoL' => $fecha_entrega]);

        //Flash::success("Se proceso  correctamente la devolución");
        //return redirect()->route('prestamo.index');

        $prestamos = DB::table('sid_pres')
            ->where('sid_pres', '=', $request->id)
            ->get();
        $detalles = DB::table('sid_pres_DETA')
            ->where('sid_pres', '=', $request->id)
            ->get();

        $prestamo = $prestamos[0];

        $recorrer = $detalles;   

       
        $view =  \View::make('pdf.devolucion', compact('prestamo', 'recorrer', 'fecha_entrega'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $name = time();
        $filename =  public_path() ."/documentos/devolucion". $name. ".pdf";
        file_put_contents($filename, $pdf->stream('devolucion'));
        //$pdf->download('prestamo.pdf');
        return $name;
        
    }


}
