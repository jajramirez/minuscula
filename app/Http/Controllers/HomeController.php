<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_TRD;
use App\SID_FUID;
use App\SID_ORGA;
use App\SID_SERI;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        set_time_limit(0);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    /**
     *   visualiza lista fuid
     */
    public function fuid(Request $request) {

        if ($request->data == "1") {


            $busqueda = '&cod_orga=' . $request->cod_orga . '&cod_seri=' . $request->cod_seri . '&Anio=' . $request->Anio .
                    '&obs_gen1=' . $request->obs_gen1 . '&obs_gen2=' . $request->obs_gen2 . '&obs_gen3=' . $request->obs_gen3 .
                    '&obs_gen4=' . $request->obs_gen4 . '&Asunto=' . $request->Asunto . '&data=1';

            $orga_d = $request->cod_orga . '';
            $consulta = DB::table('V_SIS_FUID');

            if ($request->cod_orga != null) {
                $consulta->where('V_SIS_FUID.cod_orga', '=', $orga_d);
            }

            if ($request->cod_seri != null) {
                $consulta->where('V_SIS_FUID.cod_ccd', 'like', "$request->cod_seri%");
            }
            if ($request->Anio != null) {
                $consulta->whereYear('V_SIS_FUID.fec_inic', $request->Anio);
            }
            if ($request->obs_gen1 != null) {
                $consulta->where('V_SIS_FUID.obs_gen1', 'like', "%$request->obs_gen1%");
            }

            if ($request->obs_gen2 != null) {
                $consulta->where('V_SIS_FUID.obs_gen2', 'like', "%$request->obs_gen2%");
            }
            if ($request->obs_gen3 != null) {
                $consulta->where('V_SIS_FUID.obs_gen3', 'like', "%$request->obs_gen3%");
            }

            if ($request->obs_gen4 != null) {
                $consulta->where('V_SIS_FUID.obs_gen4', 'like', "%$request->obs_gen4%");
            }

            if ($request->Asunto != null) {
                $consulta->where('V_SIS_FUID.nom_asun', 'like', "%$request->Asunto%");
            }

            if ($request->cod_bode != null) {
                $consulta->where('V_SIS_FUID.cod_bode', 'like', "%$request->cod_bode%");
            }
            if ($request->FEC_TRAN != null) {
                $consulta->where('V_SIS_FUID.FEC_TRAN', 'like', "%$request->FEC_TRAN%");
            }
            if ($request->NUM_TRAN != null) {
                $consulta->where('V_SIS_FUID.NUM_TRAN', 'like', "%$request->NUM_TRAN%");
            }


            $datos = $consulta->get();
            //dd($datos);
            $i = 0;

            $info = null;
            foreach ($datos as $d) {
                $vec = explode(".", $d->cod_ccd);
                if (count($vec) == 1) {
                    $vec[1] = '';
                }

                $info[$i] = DB::table('SID_CCD')
                        ->select('nom_subs')
                        ->where('cod_seri', '=', $vec[0])
                        ->where('cod_subs', '=', $vec[1])
                        ->get();
                $i++;
            }
        } else {
            $datos = null;
            $info = null;
            $busqueda = null;
        }

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();

        if ($request->cod_seri == null) {
            $codseri = null;
        } else {
            $codseri = $request->cod_seri;
        }


        if ($request->cod_orga == null) {
            $codorga = null;
        } else {
            $codorga = $request->cod_orga;
        }


        return view('fuid.fuid')
                        ->with('datos', $datos)
                        ->with('info', $info)
                        ->with('secuencia', 0)
                        ->with('orga', $orga)
                        ->with('seri', $seri)
                        ->with('codseri', $codseri)
                        ->with('codorga', $codorga)
                        ->with('busqueda', $busqueda);
    }

    public function carga() {


        $campos = array('cod_enti', 'cod_trd', 'num_regi', 'nom_asun', 'num_docu', 'fec_inic', 'fec_fina', 'num_carp', 'num_tomo', 'num_caja', 'num_inte',
            'num_foli', 'ban_digi', 'fre_cons', 'nom_digi', 'nom_arch', 'fec_crea', 'num_pagi', 'tam_arch', 'sof_capt', 'ver_arch',
            'res_arch', 'idi_arch', 'ent_arch', 'obs_gen1', 'obs_gen2', 'obs_gen3', 'obs_gen4');
        $long = count($campos);
        return view('fuid.carga')
                        ->with('campos', $campos)
                        ->with('long', $long);
    }

    public function store(Request $request) 
    {
        //dd("prueba");
        $respuesta = null;
        $errorSQl = null;
        //Subir archivo a servidor
        if ($request->file('url_recurso')) {
            $file = $request->file('url_recurso');
            $name = 'flr' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path() . '/cargar/';
            $file->move($path, $name);
        }

        $csv = array_map('str_getcsv', file(public_path() . '/cargar/' . $name));
        $val = $csv[0];
   
        if (is_array($val[0])) {
            //dd($val);
        } else {
            $dat = strpos($val[0], ";");
            if ($dat === false) {
                $dat = strpos($val[0], ",");
                if ($dat === false) {
                    
                } else {
                    $val = explode(",", $val[0]);
                }
            } else {
                $val = explode(";", $val[0]);
                $dat = strpos($val[0], ",");
                if ($dat === true) {
                    $val = explode(",", $val[0]);
                }
            }
        }
        $insert = "INSERT INTO SIS_FUID (`cod_enti`,`num_regi`,";

        $fec_inic = null;
        $fec_fina = null;
        $fec_tran = null;
        $num_folio = null;
        $num_pagi = null;
        $tam_arch = null;
        $num_tran = null;
        $num_orde = null;
        $cod_trd = null;
        $num_carp = null;
        $num_inte = null;
        //$num_tomo = null;
        $num_caja = null;
        $cod_bode = null;
        $fec_crea = null;
        $ent_arch = null;
        for ($i = 0; $i < count($val); $i++) {
            $val[$i] = str_replace("'", "", $val[$i]);
            $val[$i] = str_replace('"', "", $val[$i]);
            if ($val[$i] == 'fec_inic') {
                $fec_inic = $i;
            }
            if ($val[$i] == 'fec_fina') {
                $fec_fina = $i;
            }
            if ($val[$i] == 'FEC_TRAN') {
                $fec_tran = $i;
            }
            if ($val[$i] == 'num_foli') {
                $num_folio = $i;
            }
            if ($val[$i] == 'num_pagi') {
                $num_pagi = $i;
            }
            if ($val[$i] == 'tam_arch') {
                $tam_arch = $i;
            }
            if ($val[$i] == 'NUM_TRAN') {
                $num_tran = $i;
            }
            if ($val[$i] == 'num_orde') {
                $num_orde = $i;
            }
            if ($val[$i] == 'cod_trd') {
                $cod_trd = $i;
            }
            if ($val[$i] == 'num_caja') {
                $num_caja = $i;
            }
            //if($val[$i] == 'num_tomo'){
            //    $num_tomo = $i;
            //}
            if ($val[$i] == 'num_inte') {
                $num_inte = $i;
            }
            if ($val[$i] == 'num_carp') {
                $num_carp = $i;
            }
            if ($val[$i] == 'cod_bode') {
                $cod_bode = $i;
            }
            if ($val[$i] == 'fec_crea') {
                $fec_crea = $i;
            }
            if ($val[$i] == 'ent_arch') {
                $ent_arch = $i;
            }


            $insert = $insert . '`' . $val[$i] . '`';
            if ($i == count($val) - 1) {
                $insert = $insert . ',`cod_orga`,`cod_ccd`) VALUES ';
            } else {
                $insert = $insert . ',';
            }
        }

        //dd($insert);
        $cod_orga = null;
        $cod_ccd = null;
        $datosinsert = array(count($csv)-2);

        $max = DB::table('SIS_FUID')
                ->select(DB::raw('max(num_regi) as max'))
                ->get();
        $num_regi = $max[0]->max;
        $data = null;
        $incremental = 2;
        $numerovecto = 0;
        for ($i = 2; $i < count($csv); $i++) {
            $num_regi++;
            $data = "('01'," . $num_regi . ',';
            $incremental++;
            $val = $csv[$i];
            
            if (count($val) > 1) {
                for ($ih = 1; $ih < count($val); $ih++) {
                    $val[0] = $val[0] . ', ' . $val[$ih];
                }
            }

            if (is_array($val[0])) {
                
            } 
            else 
            {
                $dat = strpos($val[0], ";");
                if ($dat === false) {
                    $dat = strpos($val[0], ",");
                    if ($dat === false) {
                        
                    } else {
                        $val = explode(",", $val[0]);
                    }
                } else {
                    $val = explode(";", $val[0]);
                    $dat = strpos($val[0], ",");
                    if ($dat === true) {
                        $val = explode(",", $val[0]);
                    }
                }
            }
            
            for ($j = 0; $j < count($val); $j++) 
            {

                $val[$j] = str_replace("'", "", $val[$j]);
                $val[$j] = str_replace('"', "", $val[$j]);

                if ($val[$j] == '') {
                    if ($j == $cod_trd) {
                        $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no puede estar en blanco</br>";
                    }
                    $val[$j] = 'null';
                } else {
                    if ($j == $cod_trd) {
                        //validar que el codigo TRD exista en la base de datos
                        $con_trd = DB::table('SID_TRD')
                                ->where('SID_TRD.cod_trd', '=', $val[$j])
                                ->get();
                        if (count($con_trd) == 0) {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no coincide con ningún registro TRD</br>";
                        } else {
                            $cod_orga = $con_trd[0]->cod_orga;
                            $cod_ccd = $con_trd[0]->cod_ccd;
                            
                        }
                    }
                    if ($j == $ent_arch) {
                        if (strlen($val[$j]) > 1) {
                            $respuesta = $respuesta . "El campo Ent. Archivo  de la fila " . $incremental . " debe ser de un solo caracter.</br>";
                        }
                    }
                    if ($j == $fec_fina || $j == $fec_inic || $j == $fec_tran || $j == $fec_crea) {
                        $text = $val[$j];
                        $procesarfecha = "Y";
                        if (strlen($text) > 7 && strlen($text) < 11) {
                            
                        } else {
                            $procesarfecha = "N";
                        }
                        $pos = strpos($text, "/");
                        if ($pos === false) {
                            $pos = strpos($text, "-");
                            if ($pos === false) {
                                $procesarfecha = "N";
                            } else {
                                $sp = substr_count($text, '-');
                                if ($sp != 2) {
                                    $procesarfecha = "N";
                                }
                            }
                        } else {
                            $sp = substr_count($text, '/');
                            if ($sp != 2) {
                                $procesarfecha = "N";
                            }
                        }
                        if ($procesarfecha == "Y") {
                            $text = str_replace('/', '-', $text);
                            $fecha = strtotime($text);
                            $fecha2 = date("Y-m-d", $fecha);
                            $val[$j] = $fecha2;
                        } else {
                            $fecha2 = "ERROR";
                            $val[$j] = $fecha2;
                            if ($j == $fec_tran) {
                                $respuesta = $respuesta . "El campo Fecha Transferencia de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_fina) {
                                $respuesta = $respuesta . "El campo Fecha Inicial de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_inic) {
                                $respuesta = $respuesta . "El campo Fecha Final de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_crea) {
                                $respuesta = $respuesta . "El campo Fecha Creación de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                        }
                    }

                    //Validar los campos numericos

                    if ($j == $num_folio || $j == $num_pagi || $j == $tam_arch || $j == $num_tran || $j == $num_orde) {
                        if (is_numeric($val[$j])) {
                            
                        } else {
                            $val[$j] = "ERROR";
                            if ($j == $num_pagi) {
                                $respuesta = $respuesta . "El campo No. Paginas de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $tam_arch) {
                                $respuesta = $respuesta . "El campo Tamaño Archivo de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_tran) {
                                $respuesta = $respuesta . "El campo No. Transferencia de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_orde) {
                                $respuesta = $respuesta . "El campo No. Orden de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_folio) {
                                $respuesta = $respuesta . "El campo No. Folios de la fila " . $incremental . " debe ser numerico</br>";
                            }
                        }
                    }
                }
                if ($val[$j] == 'null') {
                    $data = $data . "" . $val[$j] . "";
                } else {
                    $data = $data . "'" . utf8_encode($val[$j]) . "'";
                }
                if ($j == count($val) - 1) {
                    $data = $data . ",'" . $cod_orga . "','" . $cod_ccd . "')";
                } else {
                    $data = $data . ",";
                }
            }
            
            $datosinsert[$numerovecto] = $data;
           
            $numerovecto++;

        }
        
        if($respuesta == null)
        {
            //insertar datos del archivo.
            DB::beginTransaction();
            try {
                    for($id=0; $id < count($datosinsert); $id++)
                    {
                        $sql = $insert . $datosinsert[$id] . ';';
                        DB::insert($sql);
                    }
                DB::commit();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $errorSQl = $ex->getMessage();
            }

            //dd($errorSQl);
            if ($errorSQl != null) {
                if ($respuesta == null) {
                    $respuesta = "Error desconocido, el archivo no cumple con el formato";
                }
                Flash::warning($errorSQl);
                return redirect()->route('home.carga');
            } else {
                Flash::success("Se cargó correctamente el archivo");
                return redirect()->route('home');
            }
        }
        else
        {
            Flash::warning($respuesta);
            return redirect()->route('home.carga');
        }

  
    }

}
