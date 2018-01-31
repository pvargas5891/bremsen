<?php

class PondaAdminModel
{

    protected $db;
    public $error;

    function PondaAdminModel()
    {
        $this->db = ADONewConnection("mysqli");
        $this->db->Connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $this->db->debug = false;
        $this->db->execute("SET NAMES 'utf8'");
    }
	function executeCommand($sql){
		return $this->db->execute($sql);
	}
  function closeConexion(){

  }
    function changeDebugState($state)
    {

        $this->db->debug = $state;

    }
   
    function getBlogs($id=""){
        $sql="";
        if($id!=""){
            $sql=" where id=".$id;
        }
        return $this->db->Execute("select * from blog".$sql);
    }
    function getRegiones()
    {
        $this->db->execute("SET NAMES 'utf8'");
        return $this->db->Execute("select * from REGION");
    }
	function getTalleresByRegion($codigo){
		$this->db->execute("SET NAMES 'utf8'");
        return $this->db->Execute("select * from talleres where region = " . $codigo);
	}
    function getCiudadesByRegion($codigo)
    {
        $this->db->execute("SET NAMES 'utf8'");
        return $this->db->Execute("select * from CIUDADES where CIU_REG_CODIGO = " . $codigo);
    }
	
    function getComunasByCiudad($dato = "")
    {
        $this->db->execute("SET NAMES 'utf8'");
        $sql = "select * from COMUNA ";
        if ($dato != "") {
            $sql .= "where COM_CIU_CODIGO = " . $dato;
        }
        $sql .= " ORDER BY COM_NOMBRE ASC";
        return $this->db->execute($sql);
    }
    function getRegionByComuna($comuna){
        $sql = "select CIU_REG_CODIGO from COMUNA,CIUDADES where COM_CODIGO =".$comuna." and CIU_CODIGO = COM_CIU_CODIGO";
        $rs=$this->db->execute($sql);
        return $rs->fields['CIU_REG_CODIGO'];
    }
    function extraeNombreCiudad($codigo)
    {
        $this->db->execute("SET NAMES 'utf8'");
        $rs = $this->db->Execute("select CIU_NOMBRE from CIUDADES where CIU_CODIGO = " . $codigo);
        return $rs->fields['CIU_NOMBRE'];
    }
    function getWebPayByPago($pago)
    {
        return $this->db->Execute("select * from webpay where Tbk_orden_compra = " . $pago);
    }

    function extraeNombreComuna($codigo)
    {
        $this->db->execute("SET NAMES 'utf8'");
        $rs = $this->db->Execute("select COM_NOMBRE from COMUNA where COM_CODIGO = " . $codigo);
        return $rs->fields['COM_NOMBRE'];
    }

    function extraeNombreRegion($codigo)
    {
        $this->db->execute("SET NAMES 'utf8'");
        $rs = $this->db->Execute("select REG_NOMBRE from REGION where REG_CODIGO = " . $codigo);
        return $rs->fields['REG_NOMBRE'];
    }

    
	
	
	
	
    function deleteProducto($id){
      $sql="delete from productos where id=".$id;
      $this->db->execute($sql);
      $sql="delete from categorias_productos where producto=".$id;
      return $this->db->execute($sql);
      $sql="delete from pistas where productos=".$id;
      return $this->db->execute($sql);
    }
	function getProductosById($id){
        $sql="select * from productos where id =".$id;        
        return $this->db->execute($sql);
    }
    function getProductosAllTotal(){
      $sql="select count(*) TOTAL from productos";
      $rs=$this->db->execute($sql);
      return $rs->fields['TOTAL'];
    }
	
	
	function getTodasLasMarcas(){
		$sql="select Marca from productos group by Marca";
        return $this->db->execute($sql);
	}
	
	function getMedidasByVehiculos($marca,$modelo,$ano){
		$sql="SELECT * FROM `VEHICULOS` WHERE MARCA = '$marca' AND MODELO = '$modelo' and ANO = '$ano'";
		return $this->db->execute($sql);
	}
	 
    function getProductosFilter($get,$tipo="*"){
	  	
      $sql="select ".$tipo." from productos where 1=1 ";
		//if($get['marca']!='undefined')
			//$sql.=" and lower(Marca) like lower('%".$get['marca']."%')";
		if($get['marcaFiltro']!='undefined')
			$sql.=" and lower(Marca) like lower('%".$get['marcaFiltro']."%')";
		if($get['atributo']!='undefined'){
			if($get['atributo']=='4x4')
				$sql.=" and lower(ultimos_dias) = 'si'";
			if($get['atributo']=='Runflat')
				$sql.=" and lower(RUNFLAT) = 'si'";
			if($get['atributo']=='Oferta')
				$sql.=" and lower(OFERTA) = 'si'";
			if($get['atributo']=='Carretera')
				$sql.=" and lower(alto_desempeno) = 'si'";
		}
		
		//if($get['modelo']!='undefined')
		//	$sql.=" and lower(MODELO) like lower('%".$get['modelo']."%')";
		
		//if($get['ano']!='undefined')
		//	$sql.=" and lower(MODELO) like lower('%".$get['modelo']."%')";
		if($get['origen']==1){
			$rs=$this->getMedidasByVehiculos($get['marca'],$get['modelo'],$get['ano']);
			$ancho=str_replace('.00','',$rs->fields['ANCHO']);
			$perfil=str_replace('.00','',$rs->fields['PERFIL']);
			$aro=$rs->fields['ARO'];
		}else{
			if($get['origen']==2){
				$ancho=$get['ancho'];
				$perfil=$get['perfil'];
				$aro=$get['aro'];
			}else{
				if($get['origen'] != 'undefined' && $get['origen'] != 'marca')
				$sql.=" and lower(MODELO) like lower('%".$get['origen']."%') or lower(Marca) like lower('%".$get['origen']."%')";
			}
		}
		if($ancho!='undefined')
			$sql.=" and lower(ANCHO) like lower('%".$ancho."%')";
		
		if($perfil!='undefined')
			$sql.=" and lower(PERFIL) like lower('%".$perfil."%')";
		
		if($aro!='undefined')
			$sql.=" and lower(ARO) like lower('%".$aro."%')";
		
		$order="Marca ASC";
		if($get['order']!='undefined'){
			if($get['order']=='marca1')
				$order="Marca ASC";
			if($get['order']=='marca2')
				$order="Marca DESC";
			
			if($get['order']=='precio1')
				$order="precio_final ASC";
			if($get['order']=='precio2')
				$order="precio_final DESC";
			
			if($get['order']=='modelo2')
				$order="MODELO ASC";
			
			if($get['order']=='modelo2')
				$order="MODELO DESC";
		}
			
		$start=$get['inicio'];
		$end=$get['fin'];	
		$sql.=" order by ".$order."";
		//if($tipo=='*')	
			//$sql.=" limit $start,$end";
      return $this->db->execute($sql);
    }
    function getProductosAll($start=0,$end=10,$order="Marca"){
        $sql="select * from productos ";
        $sql.=" order by ".$order." ASC limit $start,$end";
        return $this->db->execute($sql);
    }
	function getVehiculosSegunCampo($tipo,$campo1,$campo2="",$campo3=""){
		$sql="SELECT * FROM VEHICULOS WHERE 1 = 1";
		if($tipo==1){
			if($campo1!="")
				$sql.=" and lower(MARCA) like lower('%".$campo1."%')";
				if($campo2!="")
					$sql.=" and lower(MODELO) like lower('%".$campo2."%')";
					if($campo3!="")
						$sql.=" and lower(ANO) like lower('%".$campo3."%')";
			$sql.=" group by MARCA, MODELO, ANO";
		}else{
			if($campo1!="")
				$sql.=" and lower(ANCHO) like lower('%".$campo1."%')";
				if($campo2!="")
					$sql.=" and lower(PERFIL) like lower('%".$campo2."%')";
					if($campo3!="")
						$sql.=" and lower(ARO) like lower('%".$campo3."%')";			
			$sql.=" group by ANCHO, PERFIL, ARO";
		}
		
		return $this->db->execute($sql);
	}
	function getMarcasVehiculos(){
		$sql="SELECT MARCA FROM VEHICULOS ";
		$sql.=" group by MARCA";
		return $this->db->execute($sql);
	}
	function getModeloVehiculos($marca){
		$sql="SELECT MODELO FROM VEHICULOS WHERE MARCA = '$marca'";
		$sql.=" group by MODELO";
		return $this->db->execute($sql);
	}
	function getAnoVehiculos($modelo){
		$sql="SELECT ANO FROM VEHICULOS WHERE MODELO = '$modelo'";
		$sql.=" group by ANO";
		return $this->db->execute($sql);
	}
	function getAnchoVehiculos(){
		$sql="SELECT ANCHO FROM VEHICULOS ";
		$sql.=" group by ANCHO";
		return $this->db->execute($sql);
	}
	function getPerfilVehiculos($ancho){
		$sql="SELECT PERFIL FROM VEHICULOS WHERE ANCHO = '$ancho'";
		$sql.=" group by PERFIL";
		return $this->db->execute($sql);
	}
	function getAroVehiculos($perfil){
		$sql="SELECT ARO FROM VEHICULOS WHERE PERFIL = '$perfil'";
		$sql.=" group by ARO";
		return $this->db->execute($sql);
	}
	
    function getProductoById($id){
        $sql="select * from productos where id=".$id;
        return $this->db->execute($sql);
    }
	
    function ingresoProducto($post,$foto,$origen){

      $sql=" insert into productos values('',";
      $sql.=" '".addslashes($post['sku'])."',";
      $sql.=" '".addslashes($post['titulo'])."',";
      $sql.=" '".addslashes($post['album'])."',";
      $sql.=" '".addslashes($post['sello'])."',";
      $sql.=" '".addslashes($post['formato'])."',";
      $sql.=" '".addslashes($post['genero'])."',";
      $sql.=" '".$post['ano']."',";
      $sql.=" '".$post['stock']."',";
      $sql.=" '".$foto."',";
      $sql.=" '".$post['video']."',";
      $sql.=" '".$post['novedad']."',";
      $sql.=" '".$post['oferta']."',";
      $precio1=$post['precio'];
      $precio2=0;
      if($post['oferta']==1){
        $precio1=$post['preciooferta'];
        $precio2=$post['precio'];
      }
      $sql.=" '".$post['estado']."','".$origen."',sysdate(),'".$precio1."','".$precio2."','".$post['qty']."')";

      $this->db->execute($sql);

      $rs = $this->db->Execute("select last_insert_id() as ID");
      $id=$rs->fields['ID'];


      $discos=array();
      $discos[]=array('primero','A','B');
      $discos[]=array('segundo','C','D');
      $discos[]=array('tercero','E','F');
      $discos[]=array('cuarto','G','H');
      $discos[]=array('quinto','I','J');
      $discos[]=array('sexto','K','L');
      $discos[]=array('septimo','M','N');
      $discos[]=array('octavo','O','P');
      $discos[]=array('noveno','Q','R');
      $discos[]=array('decimo','S','T');
      $e=1;

      for($i=0;$i<count($discos);$i++){
        if($post[$discos[$i][0].$discos[$i][1].'totalpistas']>0){
          for($e=1;$e<=$post[$discos[$i][0].$discos[$i][1].'totalpistas'];$e++){
            $sql="insert into pistas values('','".addslashes($post[$discos[$i][0].$discos[$i][1].'pista'.$e])."',".$id.",'".$discos[$i][0]."','".$discos[$i][1]."')";
            $this->db->execute($sql);
          }
        }
        if($post[$discos[$i][0].$discos[$i][2].'totalpistas']>0){
          for($e=1;$e<=$post[$discos[$i][0].$discos[$i][2].'totalpistas'];$e++){
            $sql="insert into pistas values('','".addslashes($post[$discos[$i][0].$discos[$i][2].'pista'.$e])."',".$id.",'".$discos[$i][0]."','".$discos[$i][2]."')";
            $this->db->execute($sql);
          }
        }
      }

      return $id;
    }
    function actualizaProducto($post,$foto){

      $sql=" update productos set ";
      $sql.="sku='".addslashes($post['sku'])."',";
      $sql.="titulo='".addslashes($post['titulo'])."',";
      $sql.="album='".addslashes($post['album'])."',";
      $sql.="sello='".addslashes($post['sello'])."',";
      $sql.="formato='".addslashes($post['formato'])."',";
      $sql.="genero='".addslashes($post['genero'])."',";
      $sql.="ano='".$post['ano']."',";
      $sql.="stock='".$post['stock']."',";
      $precio1=$post['precio'];
      $precio2=0;
      if($post['oferta']==1){
        $precio1=$post['preciooferta'];
        $precio2=$post['precio'];
      }
      $sql.="precio='".$precio1."',";
      $sql.="preciooferta='".$precio2."',";
      if($foto!="")
        $sql.="imagen='".$foto."',";
      $sql.="video='".$post['video']."',";
      $sql.="novedad='".$post['novedad']."',";
      $sql.="oferta='".$post['oferta']."',";
      $sql.="qty='".$post['qty']."',";
      $sql.="estado='".$post['estado']."'";
      $sql.=" where id = ".$post['idproducto'];

      $this->db->execute($sql);


      $this->db->execute("delete from pistas where productos = ".$post['idproducto']);
      $discos=array();
      $discos[]=array('primero','A','B');
      $discos[]=array('segundo','C','D');
      $discos[]=array('tercero','E','F');
      $discos[]=array('cuarto','G','H');
      $discos[]=array('quinto','I','J');
      $discos[]=array('sexto','K','L');
      $discos[]=array('septimo','M','N');
      $discos[]=array('octavo','O','P');
      $discos[]=array('noveno','Q','R');
      $discos[]=array('decimo','S','T');
      $e=1;

      for($i=0;$i<count($discos);$i++){
        if($post[$discos[$i][0].$discos[$i][1].'totalpistas']>0){
          for($e=1;$e<=$post[$discos[$i][0].$discos[$i][1].'totalpistas'];$e++){
            $sql="insert into pistas values('','".addslashes($post[$discos[$i][0].$discos[$i][1].'pista'.$e])."',".$post['idproducto'].",'".$discos[$i][0]."','".$discos[$i][1]."')";
            $this->db->execute($sql);
          }
        }
        if($post[$discos[$i][0].$discos[$i][2].'totalpistas']>0){
          for($e=1;$e<=$post[$discos[$i][0].$discos[$i][2].'totalpistas'];$e++){
            $sql="insert into pistas values('','".addslashes($post[$discos[$i][0].$discos[$i][2].'pista'.$e])."',".$post['idproducto'].",'".$discos[$i][0]."','".$discos[$i][2]."')";
            $this->db->execute($sql);
          }
        }
      }
      return $post['idproducto'];
    }


    
    /*FUNCIONES DE USER*/
	
	
    function User_Data($id){
      $sql="select * from clientes where id=".$id;
      return $this->db->execute($sql);
    }
	function existeEmail($correo){
      $sql="select * from clientes where email='".$correo."'";
      return $this->db->execute($sql);
    }
	function User_Login($username,$password){
      $sql="select * from clientes where email='".$username."' and password='".$password."'";
      $rs=$this->db->execute($sql);
      return $rs;
    }
	 function registroUsuario($post){

      $sql="insert into clientes values ('',";
      $sql.="'".$post['email']."'";
      $sql.=",'".$post['password']."'";
      $sql.=",'".$post['nombreCompleto']."'";
      $sql.=",'".$post['email']."'";
      $sql.=",'".$post['region']."'";
      $sql.=",'".$post['ciudad']."'";
      $sql.=",'".$post['comuna']."'";
      $sql.=",'".$post['direccion']."'";
      $sql.=",'11111'";
      $sql.=",'".$post['telefono']."'";
      $sql.=",'".$post['genero']."')";
      $this->db->execute($sql);
    }
    function getPasswordByEmail($email){
        $sql="select password from clientes where email = '".$email."'";
        $rs=$this->db->execute($sql);
        return $rs->fields['password'];
    }
    function updateCliente($post){
      $sql="update clientes set ";
      $sql.="username='".$post['email']."'";
      $sql.=",nombres='".$post['nombreCompleto']."'";
      $sql.=",email='".$post['email']."'";
      $sql.=",region='".$post['region']."'";
      $sql.=",ciudad='".$post['ciudad']."'";
      $sql.=",comuna='".$post['comuna']."'";
      $sql.=",direccion='".$post['direccion']."'";
      $sql.=",telefono='".$post['telefono']."'";
      $sql.=",genero='".$post['genero']."' where id=".$post['id'];
      $this->db->execute($sql);
    }
    function setEmpresa($post){
	/*params.append('id', registro.id);
        params.append('razon', registro.razon);
        params.append('rutempresa', registro.rutempresa);
        params.append('giro', registro.giro);
        params.append('telefonoempresa', registro.telefonoempresa);
        params.append('direccionempresa', registro.direccionempresa);
        params.append('regionempresa', registro.regionempresa);
        params.append('ciudadempresa', registro.ciudadempresa);
        params.append('comunaempresa', registro.comunaempresa);
        params.append('accion', 'empresa');*/
        
        $rspago=$this->getPagoByUsuario($post['id']);
        $this->db->execute("delete from cliente_factura where cliente=".$post['id']." and pago=".$rspago->fields['pagosID']);

        $sql="insert into cliente_factura values ('',";
        $sql.="'".$post['id']."',";
        $sql.="'".$post['razon']."',";
        $sql.="'".$post['rutempresa']."',";
        $sql.="'".$post['giro']."',";
        $sql.="'".$post['telefonoempresa']."',";
        $sql.="'".$post['direccionempresa']."',";
        $sql.="'".$post['regionempresa']."',";
        $sql.="'".$post['ciudadempresa']."',";
        $sql.="'".$post['comunaempresa']."',";
        $sql.="'".$rspago->fields['pagosID']."'";
        $sql.=")";
      $this->db->execute($sql);

    }
    function getUltimaFacturacion($cliente){
        $sql="select * from cliente_factura where cliente =".$cliente." order by pago desc";
        return $this->db->execute($sql);
    }
	function updatePassword($post){
	  $sql="update clientes set password='".$post['password']."' where id=".$post['id'];
      $this->db->execute($sql);
	}
	
	    function getPagosByCliente($cliente)
      {
          $sql="select * from pagos,webpay where estado  = 'finalizada' and webpay.Tbk_respuesta='0' and webpay.Tbk_orden_compra=pagosID and id_usuario=".$cliente;

          return $this->db->Execute($sql);
      }
      function getPagoByUsuario($id){
          $rs= $this->db->Execute("select * from pagos where id_usuario = ".$id." and estado = 'pendiente'");
        //  $rs= $this->db->Execute("select * from pagos where id_usuario = ".$id." and pagosID = 185");
          return $rs;
      }
    
      function getPagosFinalizados($post)
{
    $sql = "select * from pagos,webpay where estado != 'pendiente'  and webpay.Tbk_orden_compra=pagosID";
    if ($post['orden'] != "")
        $sql .= " and pagosID = " . $post['orden'];
    if ($post['fechainicio'] != "") {
        $sql .= " and Tbk_fecha_contable >=  '" . $post['fechainicio'] . "'";
    }
    if ($post['fechatermino'] != "") {
        $sql .= " and Tbk_fecha_contable <=  '" . $post['fechatermino'] . "'";
    }
    $sql.=" order by Tbk_fecha_contable desc";
    return $this->db->Execute($sql);
}
    /*

      FUNCIONES CARRO
    */
	function getTipoInstalacionByComuna($comuna, $tipo=0){
		$sql="select * from instalacion where comuna =".$comuna;
    if($tipo!=0){
      $sql.=" and tipo =".$tipo;
    }
		return $this->db->Execute($sql);
	}
    function enCarro($producto,$usuario){
        $sql="select * from carro, pagos where carro.id_usuario=".$usuario." AND pagoID = pagosID AND estado = 'pendiente' and id_producto=".$producto;
        $rs = $this->db->Execute($sql);
        if(!$rs->EOF)
            return true;
        else
            return false;
    }
 function productoCarro($producto,$usuario){
        $sql="select * from carro, pagos where carro.id_usuario=".$usuario." AND pagoID = pagosID AND estado = 'pendiente' and id_producto=".$producto;
        $rs = $this->db->Execute($sql);
        return $rs;
    }

/*   METODOS PARA CARRO DE COMPRA*/
public function agregaCarro($producto, $id_usuario,$color=0,$talla=0,$cantidad,$regalo=0,$imagen="ninguna")
{

    $query = sprintf
    (
        "select * from carro, pagos where id_producto=%s AND carro.id_usuario=%s AND pagoID = pagosID AND estado = 'pendiente'",
        $this->comillas_inteligentes($producto),
        $this->comillas_inteligentes($id_usuario)
    );
    $rs = $this->db->Execute($query);

    if(!$rs->EOF){

        $query = sprintf
        (
            "UPDATE carro SET cantidad=%s,color=%s,talla=%s where id_producto=%s AND id_usuario=%s AND pagoID =%s",
            $this->comillas_inteligentes($cantidad),
            $this->comillas_inteligentes($color),
            $this->comillas_inteligentes($talla),
            $this->comillas_inteligentes($producto),
            $this->comillas_inteligentes($id_usuario),
            $this->comillas_inteligentes($rs->fields['pagosID'])
        );
        $this->db->Execute($query);
        $this->actualizaMontos($rs->fields['pagosID']);
        return;
    }


    $query = sprintf
    (
        "select pagosID, id_usuario from pagos where id_usuario=%s and estado='pendiente'",
        $this->comillas_inteligentes($id_usuario)
    );
    $rs = $this->db->Execute($query);





    $fechaactual = strftime("%m/%d/%Y %H:%M:%S %p");
    $ano = strftime("%Y", ($fechaactual));
    $mes = strftime("%m", ($fechaactual));
    $dia = strftime("%d", ($fechaactual));
    $minuto = strftime("%M", ($fechaactual));
    $segundo = strftime("%S", ($fechaactual));
    $codigo = $ano . $mes . $dia . $minuto . $segundo;

    if ($rs->EOF) {
        $consulta = "insert into pagos
                    values
                    (null,0,0,'$codigo','$codigo','" . $id_usuario . "','pendiente');
                    ";
        $this->db->Execute($consulta);
        $rs = $this->db->Execute("select last_insert_id() as pagosID");

    }

    $id_pago = $rs->fields['pagosID'];

    $insertSQL = sprintf
    (
        "INSERT INTO carro
        VALUES
        (null,%s,%s,%s,now(),now(),%s,%s,%s,%s,%s);
        ",
        $this->comillas_inteligentes($id_usuario),
        $this->comillas_inteligentes($producto),
        $this->comillas_inteligentes($cantidad),
        $this->comillas_inteligentes($id_pago),
        $this->comillas_inteligentes($regalo),
        $this->comillas_inteligentes($color),
        $this->comillas_inteligentes($talla),
        $this->comillas_inteligentes($imagen)

    );
    $this->db->Execute($insertSQL);
    $this->actualizaMontos($id_pago);


}
public  function comillas_inteligentes($valor)
{
    // Retirar las barras
    if (get_magic_quotes_gpc()) {
        $valor = stripslashes($valor);
    }

    // Colocar comillas si no es entero
    if (!is_numeric($valor)) {
        $valor = "'" . $valor . "'";
    }
    return $valor;
}
public function quitarCarro($carro){

    $insertSQL = "SELECT pagoID,id_usuario
                    FROM carro
                    WHERE id_carro =".$carro;
    $rs=$this->db->Execute($insertSQL);
	$usuario=$rs->fields['pagoID'];
    $insertSQL = "DELETE FROM carro WHERE id_carro = ".$carro;
    $this->db->Execute($insertSQL);

    $insertSQL = "SELECT count(*) TOTAL FROM carro WHERE pagoID = ".$rs->fields['pagoID'];
    $rs2=$this->db->Execute($insertSQL);
    if($rs2->fields['TOTAL']==0){
        $insertSQL = "DELETE FROM pagos WHERE pagosID = ".$rs->fields['pagoID'];
        $this->db->Execute($insertSQL);
    }else{
        $this->actualizaMontos($rs->fields['pagoID']);
    }
	
	//$insertSQL = "SELECT id_usuario FROM carro WHERE id_carro =".$carro;
//$rs=$this->db->Execute($insertSQL);
	
    return $usuario;	
	
}

function calcularPrecioIVA($precio, $iva = 19, $redondear=2)
{
    //$precioIva = ($precio * $iva / 100);

    //$precioNormalizado = floatval(sprintf("%.2f", $precioIva));
    return round($precio*$iva/100 ,$redondear);
    //return round($iva / $precio * 100, $redondear);


}
public function quitarCarroXproducto($carro){

    $insertSQL = "SELECT pagoID,cantidad FROM carro WHERE id_carro =".$carro;
    $rs=$this->db->Execute($insertSQL);
    $cant=$rs->fields['cantidad'];
    $pago=$rs->fields['pagoID'];
    $cant--;

    if($cant==0){
        $insertSQL = "DELETE FROM carro WHERE id_carro = ".$carro;
        $this->db->Execute($insertSQL);

        $insertSQL = "SELECT count(*) TOTAL FROM carro WHERE pagoID = ".$rs->fields['pagoID'];
        $rs2=$this->db->Execute($insertSQL);
        if($rs2->fields['TOTAL']==0){
            $insertSQL = "DELETE FROM pagos WHERE pagosID = ".$rs->fields['pagoID'];
            $this->db->Execute($insertSQL);
        }else{
            $this->actualizaMontos($pago);
        }


        return "final";
    }else{
        $insertSQL = "UPDATE carro SET cantidad=".$cant." WHERE id_carro = ".$carro;
        $this->db->Execute($insertSQL);
        $this->actualizaMontos($pago);
    }
    return "sigue";

}
public function getCarroTotalPorUsuario($id_usuario)
{
    $insertSQL = "select sum(cantidad) TOTAL
                    from carro, pagos
                    where carro.id_usuario ='".$id_usuario."'
                    and pagoID = pagosID
                    and estado =  'pendiente'";
    $rs=$this->db->Execute($insertSQL);
    $total=0;
    if($rs->fields['TOTAL']!=null){
        $total = $rs->fields['TOTAL'];
    }
    return $total;
}


public function vaciarCarro($user){

  $sql="select * from pagos where estado = 'pendiente' and id_usuario=".$user;
  $rs=$this->db->Execute($sql);

  $sql="delete from carro where pagoID= ".$rs->fields['pagosID']." and id_usuario=".$user;
  $this->db->Execute($sql);

  $sql="delete from pagos where estado = 'pendiente' and id_usuario=".$user;
  $rs=$this->db->Execute($sql);
}
public function updateCantidadCarro($carro,$cant){
	
	$insertSQL = "UPDATE carro SET cantidad=".$cant." WHERE id_carro = ".$carro;
    $this->db->Execute($insertSQL);
	
	$insertSQL = "SELECT * FROM carro WHERE id_carro =".$carro;
    $rs=$this->db->Execute($insertSQL);
	
    $cant=$rs->fields['id_usuario'];
    $pago=$rs->fields['pagoID'];
	
    $this->actualizaMontos($pago);
	return $cant;
}
public function getCarroPorCliente($user)
{

    $insertSQL = "select *
                    from carro, pagos
                    where carro.id_usuario ='".$user."'
                    and pagoID = pagosID
                    and estado =  'pendiente'";
    $rs=$this->db->Execute($insertSQL);

    return $rs;
}
function getDetalleCompra($pago){
  $sql="select * from detalles_compra where pagoId = ".$pago;
  return $this->db->Execute($sql);
}
public function actualizaDetallesCompra($get){

    /*params.append('regionInstalacion',carro.regionInstalacion);
      params.append('ciudadInstalacion',carro.ciudadInstalacion);
      params.append('comunaInstalacion',carro.comunaInstalacion);
      params.append('aceptaInstalacion1value',carro.aceptaInstalacion1value);
      params.append('nombresInstalacion1value',carro.nombresInstalacion1value);
      params.append('direccionInstalacion1value',carro.direccionInstalacion1value);
      params.append('aceptaInstalacion2value',carro.aceptaInstalacion2value);
      params.append('nombresInstalacion2value',carro.nombresInstalacion2value);
      params.append('direccionInstalacion2value',carro.direccionInstalacion2value);
      params.append('rutInstalacion2value',carro.rutInstalacion2value);
      params.append('aceptaInstalacion3value',carro.aceptaInstalacion3value);
      params.append('tallerAsociadovalue',carro.tallerAsociadovalue);
      params.append('fechaInstalacionvalue',carro.fechaInstalacionvalue);
      params.append('bloqueHorariovalue',carro.bloqueHorariovalue);
      params.append('direccionInstalacion4value',carro.direccionInstalacion4value);
      params.append('aceptaInstalacion4value',carro.aceptaInstalacion4value);
      params.append('tipoInstalacion',carro.tipoInstalacion);
      params.append('costoNeumaticos',carro.costoNeumaticos);
      params.append('costoInstalacion',carro.costoInstalacion);
      params.append('descuentoAplicado',carro.descuentoAplicado);
      params.append('totalTotales',carro.totalTotales);
      params.append('usuario',usuario);
      params.append('accion','actualizadetalles');*/

      $insertSQL = "select *
                    from carro, pagos
                    where carro.id_usuario ='".$get['usuario']."'
                    and pagoID = pagosID
                    and estado =  'pendiente'";
      $rs=$this->db->Execute($insertSQL);
      if($rs->EOF)
        return;

     $insertSQL = "delete from detalles_compra where usuario = ".$get['usuario']." and pagoId = ".$rs->fields['pagoID'];   
     $this->db->Execute($insertSQL);

     $insertSQL = "insert into detalles_compra values ('',";
     $insertSQL .= "".$get['usuario'].","; 
     $insertSQL .= "".$rs->fields['pagoID'].",";
     $insertSQL .= "'".$get['regionInstalacion']."',";
     $insertSQL .= "'".$get['ciudadInstalacion']."',";
     $insertSQL .= "'".$get['comunaInstalacion']."',";
     $insertSQL .= "'".$get['aceptaInstalacion1value']."',";
     $insertSQL .= "'".$get['nombresInstalacion1value']."',";
     $insertSQL .= "'".$get['direccionInstalacion1value']."',";
     $insertSQL .= "'".$get['rutInstalacion2value']."',";
     $insertSQL .= "'".$get['nombresInstalacion2value']."',";
     $insertSQL .= "'".$get['direccionInstalacion2value']."',";
     $insertSQL .= "'".$get['aceptaInstalacion3value']."',";
     $insertSQL .= "'".$get['tallerAsociadovalue']."',";
     $insertSQL .= "'".$get['fechaInstalacionvalue']."',";
     $insertSQL .= "'".$get['bloqueHorariovalue']."',";
     $insertSQL .= "'".$get['direccionInstalacion4value']."',";
     $insertSQL .= "'".$get['aceptaInstalacion4value']."',";
     $insertSQL .= "'".$get['tipoInstalacion']."',";
     $insertSQL .= "'".$get['costoNeumaticos']."',";
     $insertSQL .= "'".$get['costoInstalacion']."',";
     $insertSQL .= "'".$get['descuentoAplicado']."',";
     $insertSQL .= "'".$get['totalTotales']."')";
     
     $this->db->Execute($insertSQL);     

    $sql="update pagos set TBK_MONTO = ".$get['totalTotales']." where pagosID = ".$rs->fields['pagoID'];
    $this->db->Execute($sql);

}
public function getCarroPorPago($pago)
{

    $insertSQL = "select *
                    from carro, pagos
                    where carro.pagoID ='".$pago."'
                    and pagoID = pagosID
                    and estado !=  'pendiente'";
    $rs=$this->db->Execute($insertSQL);

    return $rs;
}

public function actualizaMontos($id_pago,$adicional=0){

    $insertSQL = "select *
                    from carro, pagos
                    where carro.pagoID ='".$id_pago."'
                    and pagoID = pagosID
                    and estado =  'pendiente'";
    $rs=$this->db->Execute($insertSQL);
    $total=0;
    while(!$rs->EOF){
        $producto=$rs->fields['id_producto'];
        $cantidad=$rs->fields['cantidad'];
        $sql="SELECT PRECIO_FINAL as precio FROM productos WHERE id = ".$producto;
        $rsT=$this->db->Execute($sql);

        $totalTmp=$rsT->fields['precio']*$cantidad;
        $total+=$totalTmp;
        $rs->movenext();
    }
    $sql="update pagos set TBK_MONTO = ".$total." where pagosID = ".$id_pago;
    $this->db->Execute($sql);
}
function porcentaje($cantidad,$porciento,$decimales){
  return $cantidad*$porciento/100;
}
/*public function actualizaCarro($post){

  print_r($post);
  //Array ( [form_key] => Vwww7itR3zQFe86m [cantidad1] => 1 [producto1] => 203 [total] => 2 [accion] => actualiza [usuario] => 2 )
  for($i=1;$i<=$post['total'];$i++){
    $total=$this->getTotalStockPorProducto($post['producto'.$i]);
    echo $total;
    if($total>0){
      if($post['cantidad'.$i]<$total){
        $sql="update carro set cantidad = ".$post['cantidad'.$i]." where id_carro=".$post['carro'.$i];
        $this->db->Execute($sql);
      }
    }

  }
  $rs=$this->getCarroPorCliente($post['usuario']);
  $this->actualizaMontos($rs->fields['pagoID']);
}*/
public function getCarroPorId($id)
{

    $insertSQL = "select *
                    from carro
                    where carro.id_carro =".$id;
    $rs=$this->db->Execute($insertSQL);
    return $rs;
}

public function getTotalStockPorProducto($code){
    $this->db->execute("SET NAMES 'utf8'");
    $sql = "select *
                from productos where id = " . $code;
    $rs=$this->db->execute($sql);
    return $rs->fields['STOCK'];
}

public function descuentaStock($code,$cantidad){
    $this->db->execute("SET NAMES 'utf8'");
    $sql = "update productos set STOCK=(STOCK-".$cantidad.") where id = " . $code;
    $this->db->execute($sql);
}
public function descuentaStockByPago($pago){
  $insertSQL = "select *
                  from carro
                  where carro.pagoID ='".$pago."'";
                  $rs=$this->db->Execute($insertSQL);
    while (!$rs->EOF) {
      $this->descuentaStock($rs->fields['id_producto'],$rs->fields['cantidad']);
      $rs->movenext();
    }
}

	function close(){
		$this->db->close();
	}
	
	
public function getDescuento($codigo){
    $sql="select * from descuentos where codigo = '".$codigo."'";
    return $this->db->Execute($sql);
}	
	
	
public function eliminaDespacho($pago){
    $this->db->Execute("delete from pagos_shipping where pago=".$pago);
}
public function getDespachoByPago($pago){
   return $this->db->Execute("select * from pagos_shipping where pago=".$pago);
}
public function setDespachoPago(){
    $this->eliminaDespacho($_POST['idpago']);
if($_POST['tipodespacho']=="1"){
  $insertSQL = "insert into pagos_shipping values( '',";
  $insertSQL .= "'".$_POST['idpago']."',";
  $insertSQL .= "'".$_POST['nombre']."',";
  $insertSQL .= "'".$_POST['email']."',";
  $insertSQL .= "'".$_POST['direccion']."',";
  $insertSQL .= "'".$_POST['region']."',";
  $insertSQL .= "'".$_POST['ciudad']."',";
  $insertSQL .= "'".$_POST['comuna']."',";
  $insertSQL .= "'".$_POST['postal']."',";
  $insertSQL .= "'',";
  $insertSQL .= "''";
  $insertSQL .= ")";
}
if($_POST['tipodespacho']=="3"){
  $insertSQL = "insert into pagos_shipping values( '',";
  $insertSQL .= "'".$_POST['idpago']."',";
  $insertSQL .= "'".$_POST['nombre']."',";
  $insertSQL .= "'".$_POST['email']."',";
  $insertSQL .= "'".$_POST['direccionfiscal']."',";
  $insertSQL .= "'".$_POST['regionfiscal']."',";
  $insertSQL .= "'".$_POST['ciudadfiscal']."',";
  $insertSQL .= "'".$_POST['comunafiscal']."',";
  $insertSQL .= "'".$_POST['postalfiscal']."',";
  $insertSQL .= "'',";
  $insertSQL .= "''";
  $insertSQL .= ")";
}

    $this->db->Execute($insertSQL);

}

}

?>
