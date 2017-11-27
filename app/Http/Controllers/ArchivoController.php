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

class ArchivoController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

     public function index(Request $request)
    {

        $detalles = DB::table('SID_EXPE_DETA_ARCH')
            ->where('cod_expe', '=', $request->cod_expe)
            ->where('num_regi', '=', $request->num_regi)
            ->get();

           return view('archivo.index')
            ->with('detalles', $detalles)
            ->with('cod_expe', $request->cod_expe)
            ->with('num_regi', $request->num_regi);
    }

    public function create(Request $request)
    {

           return view('archivo.create')
            ->with('cod_expe', $request->cod_expe)
            ->with('num_regi', $request->num_regi);
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
        $max = DB::table('SID_EXPE_DETA_ARCH')
            ->select(DB::raw('max(num_arch) as max'))
            ->get();
        
        $num_arch = $max[0]->max + 1;
        $fechaf = null;
        if($request->fec_arch != null)
        {
            $fechaf = substr($request->fec_arch,6,4) .'-'.substr($request->fec_arch,0,2) .'-'. substr($request->fec_arch,3,2);
        }

        try {
            $seri = SID_EXPE_DETA_ARCH::create([

                    'num_arch'=> $num_arch, 
                    'cod_expe'=> $request->cod_expe, 
                    'num_regi'=> $request->num_regi,  
                    'nom_arch'=> $name, 
                    'fec_arch'=> $fechaf,
                    'num_pagi'=> $request->num_pagi, 
                    'num_tama'=> $request->num_tama,
                    'nom_soft'=> $request->nom_soft,
                    'nom_vers'=> $request->nom_vers,
                    'nom_reso'=> $request->nom_reso,
                    'nom_idio'=> $request->nom_idio,
                    ]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('archivo.create', array('cod_expe' => $request->cod_expe, 'num_regi' => $request->num_regi));
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('archivo.index', array('cod_expe' => $request->cod_expe, 'num_regi' => $request->num_regi));
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
            $seri = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[1])
            ->where('num_arch', '=', $data[2])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('archivo.index', array('cod_expe' => $data[0], 'num_regi' => $data[1]));
        

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE_DETA_ARCH')
            ->where('cod_expe', '=', $data[0])
            ->where('num_regi', '=', $data[1])
            ->where('num_arch', '=', $data[2])
            ->get();


        return view('archivo.edit')
            ->with('expe', $ccd[0]);
    }


    public function actualiza(Request $request)
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

        $fechaf = null;
        if($request->fec_arch != null)
        {
            $fechaf = substr($request->fec_arch,6,4) .'-'.substr($request->fec_arch,0,2) .'-'. substr($request->fec_arch,3,2);
        }


        if($name == null){
        $seri = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $request->cod_expe)
            ->where('num_regi', '=', $request->num_regi)
            ->where('num_arch', '=', $request->num_arch)
            ->update([ 
                    'fec_arch'=>  $fechaf, 
                    'num_pagi'=> $request->num_pagi, 
                    'num_tama'=> $request->num_tama,
                    'nom_soft'=> $request->nom_soft,
                    'nom_vers'=> $request->nom_vers,
                    'nom_reso'=> $request->nom_reso,
                    'nom_idio'=> $request->nom_idio
                     ]);

        }

        else{
            $seri = SID_EXPE_DETA_ARCH::where('cod_expe', '=', $request->cod_expe)
            ->where('num_regi', '=', $request->num_regi)
            ->where('num_arch', '=', $request->num_arch)
            ->update([ 
                    'fec_arch'=>  $fechaf, 
                    'nom_arch'=> $name, 
                    'num_pagi'=> $request->num_pagi, 
                    'num_tama'=> $request->num_tama,
                    'nom_soft'=> $request->nom_soft,
                    'nom_vers'=> $request->nom_vers,
                    'nom_reso'=> $request->nom_reso,
                    'nom_idio'=> $request->nom_idio
                     ]);
        }





        Flash::warning("Se actualizó  correctamente el registro");
        return redirect()->route('archivo.index', array('cod_expe' => $request->cod_expe, 'num_regi' => $request->num_regi));

    }

    public function update(Request $request, $id)
    {

    }      



}
