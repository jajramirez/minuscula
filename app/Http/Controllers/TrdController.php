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
use App\SID_TRD;
use App\SID_TRD_DETA;
use App\SID_FUID;
use App\SID_CCD;

class TrdController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if($request->data=="1")
        {
    	  $consulta = DB::table('V_SID_TRD');

            if($request->cod_orga != null)
            {
                $consulta->where('V_SID_TRD.cod_orga' , '=', $request->cod_orga);
            }
            if($request->cod_seri != null)
            {
                $consulta->where('V_SID_TRD.cod_ccd' , 'like', "$request->cod_seri%");
            }
            $deps = $consulta->get();

            $i=0;
            $info = null;
            foreach ($deps as $d)
            {
                $vec = explode(".", $d->cod_ccd);
               if(count($vec) == 1 )
               {
                $vec[1] = '';
               }

                $info[$i] =  DB::table('SID_CCD')
                    ->select('nom_subs')
                    ->where('cod_seri' ,'=', $vec[0])
                    ->where('cod_subs' ,'=', $vec[1])
                    ->get();
               $i++;
            }

        }
        else
        {
            $info = null;
            $deps = null;
        }

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        $corga = 0;
        $cseri = 0;

        if($request->cod_seri == null)
        {
            $codseri = null;
        }
        else
        {
            $codseri = $request->cod_seri ;
            $cseri = $request->cod_seri ;
        }


        if($request->cod_orga == null)
        {
            $codorga = null;
        }
        else
        {
            $codorga = $request->cod_orga ;
            $corga = $request->cod_orga;
        }


        return view('trd.index')
       		->with('deps', $deps)
            ->with('orga', $orga)
            ->with('seri', $seri)
            ->with('codseri', $codseri)
            ->with('codorga', $codorga)
            ->with('info', $info)
            ->with('secuencia', 0)
            ->with('cseri', $cseri)
            ->with('corga', $corga);
    }
    

    public function create()
    {   

      
        $ccds = SID_CCD::all();
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        $seri = SID_SERI::all();
        return view('trd.create')
            ->with('entis', $enti)
            ->with('orgas', $orgs)
        	->with('seris', $seri)
             ->with('ccds', $ccds);
                
    }   

    public function store(Request $request)
    {  
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $trdcode = null;
        $ccdcode = null;
        if($request->cod_subs == null)
        {
            $trdcode = $request->cod_orga . '.' . $request->cod_seri;
            $ccdcode = $request->cod_seri;
        }
        else
        {
            $trdcode = $request->cod_orga . '.' . $request->cod_seri . '.' .$request->cod_subs;
            $ccdcode = $request->cod_seri . '.' .$request->cod_subs;
        }
        

       

        $trd = DB::table('SID_TRD')
            ->where('cod_trd', '=', $trdcode)
            ->where('cod_enti', '=', '01')
            ->get();
        $res = $trd->toArray();

        if(count($res) != 0)
        {
            Flash::warning("No se puede ingresar el registro, el código TRD ".$trdcode." ya existe.");
            return redirect()->route('trd.index');
        }
        else
        {
            try {


          
                
                $trd = SID_TRD::create([
             		'cod_enti'=> '01',
    				'arc_gest'=> $request->arc_gest,  
                    'cod_orga'=> $request->cod_orga, 
    				'arc_cent'=> $request->arc_cent, 
    				'ban_ct'=> $request->ban_ct, 
    				'ban_e'=> $request->ban_e, 
    				'ban_m'=> $request->ban_m,
    				'ban_s'=> $request->ban_s,
    				'tex_obse'=> $request->tex_obse,
    				'ind_esta'=> $request->ind_esta,
                    'cod_usua'=> $cod_usua,
                    'fec_actu'=> $fec_actu,
                    'hor_actu'=> $hor_actu,
                    'cod_trd'=> $trdcode, 
                    'cod_ccd' => $ccdcode ]);


                $datos = explode('^', $request->deta);
                $id_det = 1 ;
                 for($i=0; $i<=count($datos)-2; $i++)
                 {
                    $deta = SID_TRD_DETA::create([
                        'cod_enti'=> '01',
                        'num_regi'=> $id_det++ ,
                        'nom_desc'=> $datos[$i],
                        'cod_trd'=> $trdcode, 
                        'cod_usua'=> $cod_usua,
                        'fec_actu'=> $fec_actu,
                        'hor_actu'=> $hor_actu 
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
                return redirect()->route('trd.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('trd.index');
            }
        }

    }

    public function destroy($id)
    {

        $data = explode('_', $id);
    	$trd = SID_FUID::where('cod_trd', '=', $data[1])->get();
        if(count($trd)>0)
    	{
    	   Flash::success("No se puede eliminar un registro con uso en lista FUID.");
            return redirect()->route('trd.index');
    	}
    	else{
    	   $seri = SID_TRD::where('cod_trd', '=', $data[1])
                ->where('cod_enti', '=', $data[0])
                ->delete();
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('trd.index');
    	}
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        $seri = SID_SERI::all();
        $trd = DB::table('SID_TRD')
            ->where('cod_trd', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->get();
        $res = $trd->toArray();

        $codigo = $res[0]->cod_trd;
		$pos = strpos($codigo, '.');
		$cod_enti = substr($codigo ,0, $pos);
		$cod_seri = substr($codigo ,$pos+1, strlen($codigo));

        $detalle = DB::table('SID_TRD_DETA')
            ->where('cod_trd' ,'=', $res[0]->cod_trd)
            ->where('cod_enti' ,'=', $res[0]->cod_enti)
            ->get();


        $descripciondetalle = null;
        foreach ($detalle as $d) {
            $descripciondetalle = $descripciondetalle . $d->nom_desc . '^';
        }
       return view('trd.edit')
            ->with('trd', $res[0])
            ->with('enti', $enti)
            ->with('orga', $orgs)
            ->with('seri', $seri)
     		->with('codorga', $cod_enti)
            ->with('codseri', $cod_seri)
            ->with('detalle', $detalle)
            ->with('des_deta', $descripciondetalle);
    }


    public function actualizar(Request $request)
    {

        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $respuesta = null;

          $datos = explode('^', $request->deta);
          
        try {

            $seri = SID_TRD::where('cod_trd', '=', $request->cod_trd)
                ->where('cod_enti', '=', $request->cod_enti)
                ->update(['arc_gest' => $request->arc_gest,'arc_cent' => $request->arc_cent, 'ind_esta'=> $request->ind_esta,'cod_usua'=> $cod_usua,
                'fec_actu'=> $fec_actu, 'hor_actu'=> $hor_actu, 'ban_ct'=> $request->ban_ct, 'ban_e'=> $request->ban_e , 'ban_m'=> $request->ban_m,
                'ban_s'=> $request->ban_s, 'tex_obse'=> $request->tex_obse ]);



            if($request->deta != $request->original)
            {
                if($request->original != null)
                {
                    $seri = SID_TRD_DETA::where('cod_trd', '=', $request->cod_trd)
                        ->where('cod_enti', '=', $request->cod_enti )
                        ->delete();
                }

                $datos = explode('^', $request->deta);

                $id_det = 1 ;
                 for($i=0; $i<=count($datos)-2; $i++)
                 {
                    $deta = SID_TRD_DETA::create([
                        'cod_enti'=> $request->cod_enti,
                        'num_regi'=> $id_det++ ,
                        'nom_desc'=> $datos[$i],
                        'cod_trd'=> $request->cod_trd,
                        'cod_usua'=> $cod_usua,
                        'fec_actu'=> $fec_actu,
                        'hor_actu'=> $hor_actu 
                        ]);
                 }


            }   

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('trd.index');
        }
        else
        {

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('trd.index');
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function cargararchivo()
    {
        return view('trd.carga');
    }   

    public function cargartrd(Request $request)
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
        $insert = "INSERT INTO SID_TRD (`cod_enti`,";


        $cod_trd = null;
        $cod_orga = null;
        $cod_seri = null;
        $cod_subs = null;
        $ban_ct = null;
        $ban_e = null;
        $ban_m = null;
        $ban_s = null;
        $arc_gest = null;
        $arc_cent = null;
        $text_obse = null;

        for ($i = 0; $i < count($val); $i++) {
            $val[$i] = str_replace("'", "", $val[$i]);
            $val[$i] = str_replace('"', "", $val[$i]);
            if ($val[$i] == 'cod_orga') {
                $cod_orga = $i;
            }
            if ($val[$i] == 'cod_trd') {
                $cod_trd = $i;
            }
            if ($val[$i] == 'cod_seri') {
                $cod_seri = $i;
            }
            if ($val[$i] == 'cod_subs') {
                $cod_subs = $i;
            }
            if ($val[$i] == 'ban_ct') {
                $ban_ct = $i;
            }
            if ($val[$i] == 'ban_e') {
                $ban_e = $i;
            }
            if ($val[$i] == 'ban_m') {
                $ban_m = $i;
            }
            if ($val[$i] == 'ban_s') {
                $ban_s = $i;
            }
            if ($val[$i] == 'arc_gest') {
                $arc_gest = $i;
            }
            if ($val[$i] == 'arc_cent') {
                $arc_cent = $i;
            }
             if ($val[$i] == 'tex_obse') {
                $text_obse = $i;
            }

            if($val[$i] != 'cod_subs' && $val[$i] != 'cod_seri' )
            {
                $insert = $insert . '`' . $val[$i] . '`';
            }
            if ($i == count($val) - 1) {
                $insert = $insert . ', `cod_ccd`,`ind_esta`, `cod_usua`, `fec_actu`, `hor_actu`) VALUES ';
            } else {
                if($val[$i] != 'cod_subs' && $val[$i] != 'cod_seri' )
                {
                    $insert = $insert . ',';
                }
            }
        }


        $datosinsert = array(count($csv)-2);

        $data = null;
        $incremental = 2;
        $numerovecto = 0;
        for ($i = 2; $i < count($csv); $i++) {
            $incremental++;
            $data = "('01',";
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
            
            $seriebuscar = null;
            $subseriebuscar = null;
            for ($j = 0; $j < count($val); $j++) 
            {

                $val[$j] = str_replace("'", "", $val[$j]);
                $val[$j] = str_replace('"', "", $val[$j]);

                if ($val[$j] == '') {
                    if ($j == $cod_trd) {
                        $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no puede estar en blanco</br>";
                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                    }
                    else{
                        if ($j == $cod_seri) {
                            $respuesta = $respuesta . "El campo Codigo Serie de la fila " . $incremental . " no puede estar en blanco</br>";
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                        }
                        else{
                            if ($j == $cod_subs) {
                                $respuesta = $respuesta . "El campo Codigo Subserie de la fila " . $incremental . " no puede estar en blanco</br>";
                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            }
                            
                                else{
                                    if ($j == $cod_orga) {
                                        $respuesta = $respuesta . "El campo Codigo oficina productora de la fila " . $incremental . " no puede estar en blanco</br>";
                                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                    }
                                    else
                                    {
                                        if($j == $ban_ct)
                                        {
                                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                            $respuesta = $respuesta . "El campo Conservación Total  de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                        }
                                        else
                                        {
                                            if($j == $ban_e)
                                            {
                                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                $respuesta = $respuesta . "El campo Eliminación   de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                            }
                                            else
                                            {
                                                if($j == $ban_m)
                                                {
                                                    $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                    $respuesta = $respuesta . "El campo Microfilmación de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                                }
                                                else
                                                {
                                                    if($j == $ban_s)
                                                    {
                                                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                        $respuesta = $respuesta . "El campo Selección de la fila " . $incremental . " debe ser '0' o '1'</br>";     
                                                    }
                                                    else
                                                    {
                                                        if($j == $arc_cent)
                                                        {
                                                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                            $respuesta = $respuesta . "El campo Central de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                        }
                                                        else
                                                        {
                                                            if($j == $arc_gest)
                                                            {
                                                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                                $respuesta = $respuesta . "El campo Gestión de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                            }
                                                            else
                                                            {
                                                                if($j == $text_obse)
                                                                {
                                                                    $val[$j] = ' ';
                                                                    $respuesta = $respuesta . "El campo Observaciones de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                                }
                                                                else
                                                                {
                                                                    $val[$j] = 'null';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                        
                                    }
                                }
                            
                        }
                    }

                   
                } else {
                    if ($j == $cod_trd) {
                        //validar que el codigo TRD no exista en la base de datos
                        //dd($val[$j]);
                        $con_trd = DB::table('SID_TRD')
                                ->where('SID_TRD.cod_trd', '=', $val[$j])
                                ->get();
                        
                        if (count($con_trd) == 0) {
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " ya existe</br>";
                        }
                    }

                    if ($j == $cod_orga) {

                         $con_orga = DB::table('SID_ORGA')
                                ->where('SID_ORGA.cod_orga', '=', $val[$j])
                                ->get();

                        if (count($con_orga) > 0) {
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Oficina Productora de la fila " . $incremental . " no coincide </br>";
                        }
                        
                    }
                    if ($j == $cod_seri) {

                        $con_seri = DB::table('SID_SERI')
                                ->where('SID_SERI.cod_seri', '=', $val[$j])
                                ->get();
                       
                        if (count($con_seri) > 0) {
                            $seriebuscar  = $val[$j];
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $seriebuscar  = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Serie de la fila " . $incremental . " no coincide</br>";
                        }

                    }
                    if ($j == $cod_subs) {

                        $con_ccd = DB::table('SID_CCD')
                                ->where('SID_CCD.cod_seri', '=', $seriebuscar)
                                ->where('SID_CCD.cod_subs', '=', $val[$j])
                                ->get();
                        if (count($con_ccd)> 0) {
                            $subseriebuscar = $val[$j];
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $subseriebuscar = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Subserie de la fila " . $incremental . " no coincide</br>";
                        }
                        
                    }

                    if($j == $ban_ct)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Conservación Total  de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }

                    }
                    if($j == $ban_e)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Eliminación   de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $ban_m)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Microfilmación de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $ban_s)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Selección de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $arc_gest)
                    {
                        if (is_numeric($val[$j])) {
                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Gestión de la fila " . $incremental . " no puede estar en blanco</br>";
                        }
                    }
                    if($j == $arc_cent)
                    {
                        if (is_numeric($val[$j])) {
                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Central de la fila " . $incremental . " no puede estar en blanco</br>";
                        }

                    }

                }
                if($j != $cod_seri && $j != $cod_subs)
                {
                    if ($val[$j] == 'null') {
                        $data = $data . "" . $val[$j] . "";
                    } else {
                        $data = $data . "'" . utf8_encode($val[$j]) . "'";
                    }
                }
                if ($j == count($val) - 1) {
                    $ccd = $seriebuscar .'.'. $subseriebuscar;
                    $usuario = Auth::user()->cod_usua;
                    $fecha = strftime( "%Y-%m-%d", time() );
                    $hora = strftime( "%H:%M:%S", time() );
                    $data = $data . ",'".$ccd."', 'A', '".$usuario."', '".$fecha."', '".$hora."')";
                } else {
                    if($j != $cod_seri && $j != $cod_subs)
                    {
                        $data =  $data . ",";
                    }
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
                return redirect()->route('trd.cargararchivo');
            } else {
                Flash::success("Se cargó correctamente el archivo");
                return redirect()->route('trd.index');
            }
        }
        else
        {
            Flash::warning($respuesta);
            return redirect()->route('trd.cargararchivo');
        }


    } 

    public function buscarfuid(Request $request)
    {
        $trd = SID_FUID::where('cod_trd', '=', $request->cod_trd)->get(); 
        echo '<option value="" selected>Seleccione una opcion</option>'; 
        foreach ($trd as $c ){
             echo '<option value="'.$c->num_regi.'" >'.$c->num_orde.' - ' .$c->nom_asun. '</option>';
        }
    }

    public function datostrd(Request $request)
    {
       $trd = SID_FUID::where('num_regi', '=', $request->num_regi)->get();  
       return json_encode($trd[0]);
    }
}
