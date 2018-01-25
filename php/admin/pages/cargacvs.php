<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//ini_set('memory_limit', '2000M');
include_once("include/universal.php");

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include_once("include/outh.php");
//require_once dirname(__FILE__) . '/lib/phpexcel/PHPExcel.php';
// http://angelinux-slack.blogspot.com/2009/12/subir-leer-y-separar-los-datos-de-un.html
//http://cafeconweb.net/subir-archivos-al-servidor-con-ajax-sin-plugin/



  if(isset($_FILES['archivo'])){

//        print_r($_FILES);
    $leyenda = "0";
    if ($_FILES['archivo']['error']) {
        switch ($_FILES['archivo']['error']) {
            case 1: // UPLOAD_ERR_INI_SIZE
                $leyenda = "El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !";
                break;
            case 2: // UPLOAD_ERR_FORM_SIZE
                $leyenda = "El archivo sobrepasa el limite autorizado en el formulario HTML !";
                break;
            case 3: // UPLOAD_ERR_PARTIAL
                $leyenda = "El envio del archivo ha sido suspendido durante la transferencia!";
                break;
            case 4: // UPLOAD_ERR_NO_FILE
                $leyenda = "El archivo que ha enviado tiene un tamaño nulo !";
                break;
        }
    }

  }



?>
  <blockquote>
    <p>Carga Archivo Excel</p>
  </blockquote>
  <form method="post" name="leercvs" action="index.php?accion=leecvs" enctype="multipart/form-data" id="testform">
    <table class="table table-striped table-responsive">
        <tr>
          <td>Iddocumento</td>
          <td>Correlativo</td>
          <td>Rut Paciente</td>
          <td>Nombre Completo Paciente</td>
          <td>Direccion Paciente</td>
          <td>Region Paciente</td>
          <td>Comuna Paciente</td>
          <td>Telefono 1 Paciente</td>
          <td>Telefono 2 Paciente</td>
          <td>Email Paciente</td>
          <td>Rut Firmante</td>
          <td>Nombre Firmante</td>
          <td>Direccion Firmante</td>
          <td>Region Firmante</td>
          <td>Comuna Firmante</td>
          <td>Telefono 1 Firmante</td>
          <td>Telefono 2 Firmante</td>
          <td>Email Firmante</td>
          <td>Tipo Cobro</td>
          <td>Numero Ficha</td>
          <td>Numero Documento</td>
          <td>Documento Legal</td>
          <td>Monto Adeudado</td>
          <td>Fecha Vencimiento</td>
          <td>Fecha Asignacion</td>
          <td>Prevision</td>
          <td>Estado</td>
        </tr>
    </table>
    <table class="table table-striped table-responsive">
        <tr>
          <td>Selecciona la empresa asociada</td>
          <td>
            <select name="sempresa">

                <?php
                $rscli=$model->getAllNegociaciones();
                while (!$rscli->EOF){
                    echo "<option value='".$rscli->fields['idempresa']."'>".$rscli->fields['nombre']."</option>";
                    $rscli->MoveNext();
                }
                ?>
            </select>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Selecciona el ejecutivo</td>
          <td><?php
                $rsejec=$model->getAllEjecutivos();
                $i=1;
                while (!$rsejec->EOF){
                    echo '<input type="checkbox" name="ejecutivo'.$i.'" value="'.$rsejec->fields['uid'].'">'.$rsejec->fields['nombre']."<br>";
                    $rsejec->MoveNext();
                    $i++;
                }
                ?>
<input name="totalejecutivos" type="hidden" value="<?php echo $i; ?>">
          </td>
          <td>&nbsp;</td>
        </tr>

        <tr>
            <td>Subir</td>
            <td><input name="archivo" type="file" id="arccvs"></td>
            <td><span id=perfil_text>  </span></td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td><button type="submit" id="botoncargacsv" style="height: 31px;padding: 4px 16px;font-size: 12px;" name="btnBoton" value="listado" class="btn btn-danger btn-lg"> Aceptar </button></td>
          <td>&nbsp;</td>
        <tr>
    </table>
</form>


    <div id="myDivLoading">
        <img src= "<?php echo $base_url; ?>images/ajax-loader.gif" />
    </div>


    <?php
	//print_r($_FILES['archivo']);
    //if ((isset($_FILES['archivo']['name']) && ($_FILES['archivo']['error'] == UPLOAD_ERR_OK))) {
       $model->changeDebugState(true);
      echo' <script language="javascript">
              muestra();
            </script>';

        $ruta_destino = 'excel/';
        $inputFileName = $ruta_destino . str_replace(' ','_',$_FILES['archivo']['name']);
        $inputFileName = $ruta_destino."matrizindisa.csv";
      //  move_uploaded_file($_FILES['archivo']['tmp_name'], $inputFileName);

        try {
      /*$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($inputFileName);

      $sheet=  $objPHPExcel->getSheet(0);*/
//        if (($gestor = fopen($rutafinal, "r")) !== FALSE) {
//           echo "entre";
//        }
//        $fp = fopen ( $rutafinal , "r" );
//$highestRow = $sheet->getHighestRow();
//$highestColumn = $sheet->getHighestColumn();
                //echo "<pre>";
                //print_r($datos);
                //echo "</pre>";


$totalejecutivos=array();;
for($i=0;$i<$_POST['totalejecutivos'];$i++){
    if(isset($_POST['ejecutivo'.$i])){
      $totalejecutivos[]=$_POST['ejecutivo'.$i];
    }
}
$todalainfo=array();
/*for ($row = 1; $row <= $highestRow; $row++){
    //  Read a row of data into an array
    $primero = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
    $datos=$primero[0];
    //if($datos[8]!="")
      $todalainfo[]=$datos;
}*/
/*if (($fichero = fopen($inputFileName, "r")) !== FALSE) {
    while (($datos = fgetcsv($fichero, 1000)) !== FALSE) {
        // Procesar los datos.
        // En $datos[0] está el valor del primer campo,
        // en $datos[1] está el valor del segundo campo, etc...
          $todalainfo[]=$datos;
    }
}*/
$registros = array();

if (($fichero = fopen($inputFileName, "r")) !== FALSE) {
    // Lee los nombres de los campos
    $nombres_campos = fgetcsv($fichero, 0, ";", "\"", "\"");
    $num_campos = count($nombres_campos);
    // Lee los registros
    while (($datos = fgetcsv($fichero, 0, ";", "\"", "\"")) !== FALSE) {
        // Crea un array asociativo con los nombres y valores de los campos
        /*for ($icampo = 0; $icampo < $num_campos; $icampo++) {
            $registro[$nombres_campos[$icampo]] = $datos[$icampo];
        }*/
        // Añade el registro leido al array de registros
        //$registros[] = $registro;
        $todalainfo[]=$datos;
      //  print_r($datos);
      // echo '<br><br>';
    }
    fclose($fichero);

    /*echo "Leidos " . count($registros) . " registros\n";

    for ($i = 0; $i < count($registros); $i++) {
        echo "Nombre: " . $registros[$i]["nombre"] . "\n";
    }*/
}
//exit;
$model->changeDebugState(true);

$totalinfo=count($todalainfo);
echo 'Total de filas:'.$totalinfo."<br>";
$sobra=$totalinfo%count($totalejecutivos);
echo 'Diferencia:'.$sobra."<br>";
$totalinfo=$totalinfo-$sobra;
echo 'Total Ajustado:'.$totalinfo."<br>";
$cadauno=$totalinfo/count($totalejecutivos);
echo 'Filas para cada '.count($totalejecutivos).' ejecutivos:'.$cadauno;
$actual=1;
$cadauno2=$cadauno;
$totalinsertados=0;
for($i=0;$i<count($totalejecutivos);$i++){
  for($j=$actual;$j<=$cadauno;$j++){
      $r=$j-1;
      $datos=$todalainfo[$r];
      print_r($datos);
      $idocumento=$datos[0];
      $correlativo=$datos[1];
      $rutp     = $datos[2];
      $NomPaci  = $datos[3];
      $paternop = '';
      $maternop = '';
      $DirPaci  = $datos[4];
      $RegPac   = $datos[5];
      $ComPac	  = $datos[6];
      $Tel1pac  = $datos[7];
      $Tel2pac  = $datos[8];
      $mailpac  = $datos[9];  //
// Firmantes

      $rutf     = $datos[10];
      $nomfir   = $datos[11];
      $patfir   = '';
      $matfir   = '';
      $dirfir   = $datos[12];
      $regfir   = $datos[13]; //
      $comfir   = $datos[14]; //
      $tel1fir  = $datos[15];
      $tel2fir  = $datos[16];
      $mailfir  = $datos[17];
      $notifica = 0;
      $cartterm = 0;
      $cartcamp = 0;



// deuda
      $idempr   = $_POST['sempresa'];
      $idtcobro = $datos[18];
      $numfich  = $datos[19];
      $numdoc   = $datos[20];
      $doculeg  = $datos[21];
      $monto    = str_replace('.','',$datos[24]);

      $nuevafecha = strtotime ($datos[25]) ;
      $fecha = date ( 'Y-m-d' , $nuevafecha );
      $fechvenc = $fecha;

      $nuevafecha = strtotime (str_replace(' ','',$datos[25])) ;
      $fecha = date ( 'Y-m-d' , $nuevafecha );
      $fechasig = $fecha;


      $idprevi  = '';
      $idestado = $model->getEstadoByNombre($datos[26]);
      $user     = $model->getEjecutivoByNombre($datos[27]);

      //$user     = $totalejecutivos[$i];
/*getEjecutivoByNombre
delete FROM `deuda` WHERE 1;
delete FROM `firmante` WHERE 1;
delete FROM `paciente` WHERE 1;
delete FROM `relafirmantepago` WHERE 1;

*/
if(is_numeric($numdoc)){
$resultado=$model->InsertaDeudor( $rutp,
                               $NomPaci,
                               $paternop,
                               $maternop,
                               $DirPaci,
                               $RegPac,
                               $ComPac,
                               $Tel1pac,
                               $Tel2pac,
                               $mailpac,
                                        // Firmantes

                               $rutf,
                               $nomfir,
                               $patfir,
                               $matfir,
                               $dirfir,
                               $regfir,
                               $comfir,
                               $tel1fir,
                               $tel2fir,
                               $mailfir,
                               $notifica,
                               $cartterm,
                               $cartcamp,

                                 // deuda
                              $idempr,
                              $idtcobro,
                              $numfich,
                              $numdoc,
                              $doculeg,
                              $monto,
                              $fechvenc,
                              $fechasig,
                              $idprevi,
                              $idestado,
                              $user,
                              $idocumento,
                              $correlativo);

                            if($resultado==1)
                              $totalinsertados++;
      }else{
        echo 'El numero de documento '.$numdoc.' no es numerico, porfavor revise su planilla y ubique el problema<br>';
      }
      echo "<p> $j Numdoc: $numdoc, Rut Paciente: $rutp, Rut Firmante: $rutf ,Ejecutivo Asignado: $user <br /></p>\n";
  }
  $cadauno+=$cadauno2;
  $actual+=$cadauno2;
}
if($sobra>0){
$inicial=$totalinfo+1;
$totalinfo=$totalinfo+$sobra;
echo "Diferencia a insertar:".$sobra."<br>";
echo "Estos datos fueron insertados al ultimo usuario seleccionado:<br>";

for($i=$inicial;$i<=$totalinfo;$i++){
  $r=$i-1;
  $datos=$todalainfo[$r];
  $rutp     = $datos[0];
  $NomPaci  = $datos[1];
  $paternop = '';
  $maternop = '';
  $DirPaci  = $datos[2];
  $RegPac   = $datos[3];
  $ComPac	  = $datos[4];
  $Tel1pac  = $datos[5];
  $Tel2pac  = $datos[6];
  $mailpac  = $datos[7];  //
// Firmantes

  $rutf     = $datos[8];
  $nomfir   = $datos[9];
  $patfir   = '';
  $matfir   = '';
  $dirfir   = $datos[10];
  $regfir   = $datos[11]; //
  $comfir   = $datos[12]; //
  $tel1fir  = $datos[13];
  $tel2fir  = $datos[14];
  $mailfir  = $datos[15];
  $notifica = 0;
  $cartterm = 0;
  $cartcamp = 0;



// deuda
  $idempr   = $_POST['sempresa'];
  $idtcobro = 1;
  $numfich  = $datos[16];
  $numdoc   = $datos[17];
  $doculeg  = $datos[18];
  $monto    = str_replace('.','',$datos[19]);
  $fechvenc = str_replace('/','-',$datos[20]);
  $fechasig = str_replace('/','-',$datos[21]);
  $idprevi  = $datos[22];
  $idestado = 1;
  if(is_numeric($numdoc)){
  $resultado=$model->InsertaDeudor( $rutp,
                                 $NomPaci,
                                 $paternop,
                                 $maternop,
                                 $DirPaci,
                                 $RegPac,
                                 $ComPac,
                                 $Tel1pac,
                                 $Tel2pac,
                                 $mailpac,
                                          // Firmantes

                                 $rutf,
                                 $nomfir,
                                 $patfir,
                                 $matfir,
                                 $dirfir,
                                 $regfir,
                                 $comfir,
                                 $tel1fir,
                                 $tel2fir,
                                 $mailfir,
                                 $notifica,
                                 $cartterm,
                                 $cartcamp,

                                   // deuda
                                $idempr,
                                $idtcobro,
                                $numfich,
                                $numdoc,
                                $doculeg,
                                $monto,
                                $fechvenc,
                                $fechasig,
                                $idprevi,
                                $idestado,
                                $user );
                                if($resultado==1)
                                  $totalinsertados++;
        }else{
          echo 'El numero de documento no es numerico, porfavor revise su planilla y ubique el problema<br>';
        }
    echo "<p> $j Numdoc: $numdoc, Rut Paciente: $rutp, Rut Firmante: $rutf ,Ejecutivo Asignado: $user <br /></p>\n";
}
}
echo "Total Insertados:".$totalinsertados;
// paciente
            /*  $rutp     = $datos[0];
              $NomPaci  = $datos[1];
              $paternop = '';
              $maternop = '';
              $DirPaci  = $datos[2];
              $RegPac   = $datos[3];
              $ComPac	  = $datos[4];
              $Tel1pac  = $datos[5];
              $Tel2pac  = $datos[6];
              $mailpac  = $datos[7];  //
// Firmantes

              $rutf     = $datos[8];
              $nomfir   = $datos[9];
              $patfir   = '';
              $matfir   = '';
              $dirfir   = $datos[10];
              $regfir   = $datos[11]; //
              $comfir   = $datos[12]; //
              $tel1fir  = $datos[13];
              $tel2fir  = $datos[14];
              $mailfir  = $datos[15];
              $notifica = 0;
              $cartterm = 0;
              $cartcamp = 0;



// deuda
              $idempr   = $_POST['sempresa'];
              $idtcobro = 1;
              $numfich  = $datos[16];
              $numdoc   = $datos[17];
              $doculeg  = $datos[18];
              $monto    = str_replace('.','',$datos[19]);
              $fechvenc = str_replace('/','-',$datos[20]);
              $fechasig = str_replace('/','-',$datos[21]);
              $idprevi  = $datos[22];
              $idestado = 1;
              $user     = $_POST['vejec'];*/
/*
delete FROM `deuda` WHERE 1;
delete FROM `firmante` WHERE 1;
delete FROM `paciente` WHERE 1;
delete FROM `relafirmantepago` WHERE 1;

*/
            //  echo "<br><p>  Numdoc: $numdoc, Rut Paciente: $rutp, Rut Firmante: $rutf <br /></p>\n";


            /*  $rscli=$model->InsertaDeudor( $rutp,
                                            $NomPaci,
                                            $paternop,
                                            $maternop,
                                            $DirPaci,
                                            $RegPac,
                                            $ComPac,
                                            $Tel1pac,
                                            $Tel2pac,
                                            $mailpac,
                                                     // Firmantes

                                            $rutf,
                                            $nomfir,
                                            $patfir,
                                            $matfir,
                                            $dirfir,
                                            $regfir,
                                            $comfir,
                                            $tel1fir,
                                            $tel2fir,
                                            $mailfir,
                                            $notifica,
                                            $cartterm,
                                            $cartcamp,

                                              // deuda
                                           $idempr,
                                           $idtcobro,
                                           $numfich,
                                           $numdoc,
                                           $doculeg,
                                           $monto,
                                           $fechvenc,
                                           $fechasig,
                                           $idprevi,
                                           $idestado,
                                           $user );*/







          } catch (Exception $e) {
              die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME). '": ' . $e->getMessage());
          }

    //}


    echo' <script language="javascript">
              oculta();
          </script>';


    if ($leyenda != "0"){
           echo "</br></br><h3> $leyenda <h3>";
     }else{
        echo "</br></br><h3> Proceso Terminado <h3>";
    }

    ?>
