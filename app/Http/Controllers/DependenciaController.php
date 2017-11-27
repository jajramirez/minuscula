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

class DependenciaController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

     //
    public function index(Request $request)
    {

    	  $deps = DB::table('SID_ORGA')
            ->select('cod_enti', 'cod_orga', 'nom_orga', 'cod_nive', 'ind_esta', 'cod_padr', 'cod_usua', 'fec_actu', 'hor_actu',  'PATH')
            ->where('nom_orga', 'like', "%$request->nom_orga%")
            ->get();

        return view('dependencias.index')
       		->with('deps', $deps);
    }
    

    public function create()
    {   
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        return view('dependencias.create')
            ->with('entis', $enti)
            ->with('orgs', $orgs);
    }   

    public function store(Request $request)
    {
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );

        $deps = DB::table('SID_ORGA')
            ->where('cod_enti', '=', "01")
            ->where('cod_orga', '=', $request->cod_orga)
            ->get();

        if(count($deps) == 0)
        {
            try {
                $seri = SID_ORGA::create([

                        'cod_enti'=> '01' ,
                        'cod_orga'=> $request->cod_orga,
                        'nom_orga'=> $request->nom_orga,
                        'ind_esta'=> $request->ind_esta,
    		            'PATH'=> $request->PATH,
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
                return redirect()->route('dependencias.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('dependencias.index');
            }

        }
        else
        {
            Flash::warning("El codigo ". $request->cod_orga . " ya existe en la base de datos.");
            return redirect()->route('dependencias.index');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);
	$sid_seri = SID_FUID::where('cod_orga', '=', $data[1])->get();
	if(count($sid_seri)>0)
        {
	Flash::success("No se puede eliminar un registro en uso por lista FUID");
        return redirect()->route('dependencias.index');
	}
	else{
        $seri = SID_ORGA::where('cod_orga', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('dependencias.index');
	 }
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();            
        $seri = DB::table('SID_ORGA')
            ->select('cod_enti', 'cod_orga', 'nom_orga', 'cod_nive', 'ind_esta', 'cod_padr',  'PATH')
            ->where('cod_orga', '=', $data[1])
            ->where('cod_enti', '=', $data[0])
            ->get();
        $res = $seri->toArray();
        return view('dependencias.edit')
            ->with('seri', $res[0])
            ->with('entis', $enti)
            ->with('orgs', $orgs);
    }


    public function actualizar(Request $request)
    {
        date_default_timezone_set('America/Bogota');
        $cod_usua = Auth::user()->cod_usua;
        $fec_actu = strftime( "%Y-%m-%d", time() );
        $hor_actu = strftime( "%H:%M:%S", time() );
        $seri = SID_ORGA::where('cod_orga', '=', $request->cod_orga)
            ->where('cod_enti', '=', $request->cod_enti)
            ->update(['nom_orga' => $request->nom_orga, 'ind_esta'=> $request->ind_esta,'cod_usua'=> $cod_usua,
            'fec_actu'=> $fec_actu, 'hor_actu'=> $hor_actu,  'PATH'=> $request->PATH]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('dependencias.index');
    }

    public function update(Request $request, $id)
    {

    }      
}
