<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\V_SID_TRD_DETA;
use App\SID_TRD;
use App\SID_TRD_DETA;
use App\SID_TMP_TRD;
use App\SID_ORGA;
use App\SID_SERI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MBarryvdh\DomPDF\Facade;
 
 
class PdfController extends Controller {
 
    public function index()
    {
    $text = "2008-1-6";
    //$text = "1/9/2008";
    //$text = "13-12-2008";
    $procesarfecha = "Y";
    if(strlen($text) > 7 && strlen($text) <11  )
    {

    }
    else
    {
        $procesarfecha = "N";
    }

    $pos = strpos($text, "/");
    if($pos === false )
    {
        $pos = strpos($text, "-");
        if($pos === false )
        {
            $procesarfecha = "N";
        }
        else{
            $sp = substr_count($text, '-');
            if($sp != 2)
            {
                $procesarfecha = "N";
            }
        }
    }
    else
    { 
        $sp = substr_count($text, '-');
        if($sp != 2)
        {
            $procesarfecha = "N";
        }
    }
    if($procesarfecha == "Y")
    {
        $text = str_replace('/', '-', $text);
        $fecha=strtotime($text);
        $fecha2 = date("Y-m-d",$fecha);
    }
    else
    {
        $fecha2 = "ERROR";
    }
    

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        return view('pdf.generate')
            ->with('orga', $orga)
            ->with('seri', $seri);
    }
    public function trd($id, $id2)
    {


      $eliminar = SID_TMP_TRD::where('cod_usua', '=', Auth::user()->cod_usua)
                 ->delete();

        $trd = SID_TRD::select('cod_trd', 'arc_gest', 'arc_cent', 'ban_ct', 'ban_e', 'ban_m', 'ban_s', 'tex_obse', 'ind_esta');
        if($id != "0")
            $trd->where('cod_orga', '=', $id);
        if($id2 != "0")
            $trd->where('cod_trd', '=', $id2);

        $trd_res = $trd->get();

	$orga = SID_ORGA::where('cod_orga' , '=', $id)->get();

        foreach ($trd_res as $reg) {

            if($reg->ban_ct == '1')
                {
                    $reg->ban_ct = 'SI';
                }
                else
                {
                    $reg->ban_ct = '';
                }
                if($reg->ban_e == '1')
                {
                    $reg->ban_e = 'SI';
                }
                else
                {
                    $reg->ban_e = '';
                }
                if($reg->ban_m == '1')
                {
                    $reg->ban_m = 'SI';
                }
                else
                {
                    $reg->ban_m = '';
                }
                if($reg->ban_s == '1')
                {
                    $reg->ban_s = 'SI';
                }
                else
                {
                    $reg->ban_s = '';
                }   
                $insert = 'INSERT INTO `SID_TMP_TRD`(`trd_tmp1`, `trd_tmp2`, `trd_tmp3`, `trd_tmp4`, `trd_tmp5`, 
                        `trd_tmp6`, `trd_tmp7`, `trd_tmp8`, `trd_tmp9`, `cod_usua`) VALUES (';
            
                $datostrd ="'".$reg->cod_trd."','".$reg->arc_gest."','".$reg->arc_cent."','"
                        .$reg->ban_ct."','".$reg->ban_e."','".$reg->ban_m."','"
                        .$reg->ban_s."','".$reg->tex_obse."','".$reg->ind_esta."','".Auth::user()->cod_usua. "')";

                DB::insert($insert.$datostrd);                  
                $trddeta  = SID_TRD_DETA::select('nom_desc', 'num_regi')
                        ->where('cod_trd', '=', $reg->cod_trd)
                        ->get();

                foreach ($trddeta as $deta) {
                    $insert = 'INSERT INTO `SID_TMP_TRD`(`trd_tmp1`, `trd_tmp2`, `trd_tmp3`, `trd_tmp4`, `trd_tmp5`, 
                    `trd_tmp6`, `trd_tmp7`, `trd_tmp8`, `trd_tmp9`,`cod_usua`) VALUES (';
                    $valor = $deta->nom_desc;
                    $datostrd ="'','','','','','','','".$valor."','','".Auth::user()->cod_usua. "')";
                    DB::insert($insert.$datostrd);
                }
            }

                
            //$consulta = SID_TMP_TRD::select('trd_tmp1 as Codigo', 'trd_tmp2 as Gestion', 'trd_tmp3 as Cent', 
            //           'trd_tmp4 as CT', 'trd_tmp4 as E', 'trd_tmp5 as M', 'trd_tmp6 as M', 'trd_tmp7 as S',
            //            'trd_tmp8 as Observaciones', 'trd_tmp9 as Estado');

            $consulta = SID_TMP_TRD::select('trd_tmp1', 'trd_tmp2', 'trd_tmp3', 
                        'trd_tmp4', 'trd_tmp5', 'trd_tmp6', 'trd_tmp7',
                        'trd_tmp8', 'trd_tmp9');
            $products= $consulta->where('cod_usua', '=', Auth::user()->cod_usua)->get();



        //dd($products);

        $view =  \View::make('pdf.invoice', compact('products', 'orga'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //return $pdf->stream('invoice');

        //return view('pdf.invoice')->with('products', $products);
        return $pdf->download('trd.pdf');
    }


}
