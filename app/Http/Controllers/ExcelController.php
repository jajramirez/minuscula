<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\V_SID_TRD_DETA;
use App\SID_TRD;
use App\SID_ORGA;
use App\SID_TRD_DETA;
use App\SID_TMP_TRD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
 
 
class ExcelController extends Controller {
 
 /**
 * Display a listing of the resource.
 *
 * @return Response
 */
 public function index($orga, $seri)
 {

        Excel::create('TRD_detalle', function($excel) use($orga, $seri) {
            

            $excel->sheet('Detalle TRD', function($sheet) use($orga, $seri) {

                $eliminar = SID_TMP_TRD::where('cod_usua', '=', Auth::user()->cod_usua)
                    ->delete();

                $trd = SID_TRD::select('cod_trd', 'arc_gest', 'arc_cent', 'ban_ct', 'ban_e', 'ban_m', 'ban_s', 'tex_obse', 'ind_esta');
                if($orga != "0")
                    $trd->where('cod_orga', '=', $orga);
                if($seri != "0")
                    $trd->where('cod_trd', '=', $seri);

                $trd_res = $trd->get();

                

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
                        $valor = $deta->num_regi .' - ' .$deta->nom_desc;
                        $datostrd ="'','','','','','','','".$valor."','','".Auth::user()->cod_usua. "')";
                        DB::insert($insert.$datostrd);
                    }


                }

                $dataorga = SID_ORGA::where('cod_orga' , '=', $orga)->get();

                
               //$consulta = SID_TMP_TRD::select('trd_tmp1 as Codigo', 'trd_tmp2 as Gestion', 'trd_tmp3 as Cent', 
                //        'trd_tmp4 as CT', 'trd_tmp5 as E', 'trd_tmp6 as M',  'trd_tmp6 as S',
                //        'trd_tmp7 as Observaciones', 'trd_tmp8 as Estado');

               $consulta = SID_TMP_TRD::select('trd_tmp1', 'trd_tmp2', 'trd_tmp3', 
                        'trd_tmp4', 'trd_tmp5', 'trd_tmp6', 'trd_tmp7',
                        'trd_tmp8', 'trd_tmp9');
               $products= $consulta->where('cod_usua', '=', Auth::user()->cod_usua)->get();

               $sheet->row(1, array('', '', 'Tabla de Retención Documental'));

               $sheet->row(2, array('', ));
               $sheet->row(3, array('Entidad Productora','Escuela Administración Publica'));
               $sheet->row(4, array('Oficina Productora',$dataorga[0]->nom_orga));
               $sheet->row(5, array('', ));
               $sheet->row(6, array('Código', 'Gestión', 'Cent', 'CT', 'E', 'M', 'S', 'Observaciones'));
               $i = 7   ;
               foreach ($products as $p) 
               {
                 $sheet->row($i, array($p->trd_tmp1, $p->trd_tmp2,$p->trd_tmp3, $p->trd_tmp4, $p->trd_tmp5, $p->trd_tmp6, $p->trd_tmp7, $p->trd_tmp8));
                 $i++;
               }
               $hoja = $i;
               

                $i++;
                $i++;
                $sheet->row($i, array('Conversiones'));
                $i++;
                $sheet->row($i, array('CT => Conservación Total'));
                $i++;
                $sheet->row($i, array('E => Eliminación','','','','Firma Responsable'));
                $i++;
                $sheet->row($i, array('M => Microfilmación'));
                $i++;
                $sheet->row($i, array('S => Selección'));
                  

               $sheet->setWidth('A', 12);
               $sheet->setWidth('D', 3);
               $sheet->setWidth('E', 3);
               $sheet->setWidth('F', 3);
               $sheet->setWidth('G', 3);
               $sheet->setWidth('H', 50);

               $sheet->setBorder('A6:H'.$hoja, 'thin');

               $sheet->setStyle(array(
                        'font' => array(
                        'name'      =>  'Arial',
                        'size'      =>  '10'
                    )
                ));

               $sheet->cells('A1:H6', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
               });                 
 
            });
        })->export('xls');
 
 }
}
