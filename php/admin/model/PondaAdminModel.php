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
    function registroUsuario($post){

      /*
      Array ( [rut] => 15794539-4
      [nombre] => Pablo
      [apellido] => Vargas
      [email] => pvargafi@gmail.com
      [region] => 13
      [ciudad] => 44
      [comuna] => 308
      [direccion] => estadio sanchez rumoroso 187
      [codigopostal] => 8721509
      [password] => admin

      */
      $sql="insert into clientes values ('',";
      $sql.="'".$post['email']."'";
      $sql.=",'".$post['password']."'";
      $sql.=",'".$post['nombre']."'";
      $sql.=",'".$post['apellido']."'";
      $sql.=",'".$post['email']."'";
      $sql.=",'".$post['region']."'";
      $sql.=",'".$post['ciudad']."'";
      $sql.=",'".$post['comuna']."'";
      $sql.=",'".$post['direccion']."'";
      $sql.=",'".$post['codigopostal']."'";
      $sql.=",'".$post['telefono']."'";
      $sql.=",'".$post['rut']."')";
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
      if($post['password']!="")
        $sql.=",password='".$post['password']."'";
      $sql.=",nombres='".$post['nombre']."'";
      $sql.=",apellido='".$post['apellido']."'";
      $sql.=",email='".$post['email']."'";
      $sql.=",region='".$post['region']."'";
      $sql.=",ciudad='".$post['ciudad']."'";
      $sql.=",comuna='".$post['comuna']."'";
      $sql.=",direccion='".$post['direccion']."'";
      $sql.=",codigopostal='".$post['codigopostal']."'";
      $sql.=",rut='".$post['rut']."' where id=".$post['id'];
      $this->db->execute($sql);
    }
    function getSucursalByComuna($comuna){
      $sql="select * from sucursales_chileexpress where region = ".$comuna;
      return   $this->db->execute($sql);
    }
    function saveSucursal($sucursal,$pago){
      $sql="delete from pago_sucursal where pago = ".$pago;
      $this->db->execute($sql);
      $sql="insert into pago_sucursal values('','".$pago."','".$sucursal."')";
      $this->db->execute($sql);
    }
    function getSucursalByPago($pago){
      $sql="select * from pago_sucursal where pago = ".$pago;
      return   $this->db->execute($sql);
    }
    function extraeNombreSuc($suc){
      $sql="select * from sucursales_chileexpress where id = ".$suc;
      $rs=$this->db->execute($sql);
      return $rs->fields['nombre'];
    }

    function getRegiones()
    {
        $this->db->execute("SET NAMES 'utf8'");
        return $this->db->Execute("select * from REGION");
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


    function deleteBlog($id){
        $this->db->Execute("delete from blog where id=".$id);
    }

    function getProductosFilterTotal($origen,$artista){
      $sql="select count(*) TOTAL from productos where lower(titulo) like lower('%".$artista."%')";
      $rs=$this->db->execute($sql);
      return $rs->fields['TOTAL'];
    }
    function deleteProducto($id){
      $sql="delete from productos where id=".$id;
      $this->db->execute($sql);
      $sql="delete from categorias_productos where producto=".$id;
      return $this->db->execute($sql);
      $sql="delete from pistas where productos=".$id;
      return $this->db->execute($sql);
    }
    function getProductosAllTotal(){
      $sql="select count(*) TOTAL from productos";

       // $sql.=" where origen='".$origen."'";

      $rs=$this->db->execute($sql);
      return $rs->fields['TOTAL'];
    }
    function getProductosFilter($origen,$artista,$start,$end){
      $sql="select * from productos where lower(titulo) like lower('%".$artista."%')";

        $sql.=" and origen='".$origen."'";
        $sql.=" order by id DESC limit $start,$end";
      return $this->db->execute($sql);
    }
    function insertaProducto($todalainfo){

      $sql="select * from productos where CODIGO = ".$todalainfo[0];
      $rs=$this->db->execute($sql);
      $id="";
      if(!$rs->EOF){
        $id=$rs->fields['id'];
        $sql="delete from productos where id = ".$id;
        $this->db->execute($sql);

      }

       $sql="insert into productos values ('".$id."',";
              $sql.=$todalainfo[0].",";
              $sql.=$todalainfo[1].",";
              $sql.=$todalainfo[2].",";
              $sql.=$todalainfo[3].",";
              $sql.=$todalainfo[4].",";
              $sql.=$todalainfo[5].",";
              $sql.=$todalainfo[6].",";
              $sql.=$todalainfo[7].",";
              $sql.=$todalainfo[8].",";
              $sql.=$todalainfo[9].",";
              $sql.=$todalainfo[10].",";
              $sql.=$todalainfo[11].",";
              $sql.=$todalainfo[12].",";
              $sql.=$todalainfo[13].",";
              $sql.=$todalainfo[14].",";
              $sql.=$todalainfo[15].",";
              $sql.=$todalainfo[16].",";
              $sql.=$todalainfo[17].",";
              $sql.=$todalainfo[18].",";
              $sql.=$todalainfo[19].",";
              $sql.=$todalainfo[20].",";
              $sql.=$todalainfo[21].",";
              $sql.=$todalainfo[22].",";
              $sql.=$todalainfo[23].",";
              $sql.=$todalainfo[24].",";
              $sql.=$todalainfo[25].",";
              $sql.=$todalainfo[26].",";
              $sql.=$todalainfo[27].",";
              $sql.=$todalainfo[28].",";
              $sql.=$todalainfo[29].",";
              $sql.=$todalainfo[30].",";
              $sql.=$todalainfo[31].")";
              $this->db->execute($sql);
    }

    function getProductosAll($start,$end){
        $sql="select * from productos ";

         // $sql.=" where origen='".$origen."'";

        $sql.=" order by id DESC limit $start,$end";
        return $this->db->execute($sql);
    }
    function getProductosFilterTotalAdmin($dato){
    $sql="SELECT count(*) as TOTAL FROM `productos` WHERE lower(Marca) like lower('%".$dato."%') or lower(MODELO) like lower('%".$dato."%')";
    $rs=$this->db->execute($sql);
    return $rs->fields['TOTAL'];
   }
   function getProductosFilterAdmin($dato, $start,$end){
    $sql="SELECT * FROM `productos` WHERE lower(Marca) like lower('%".$dato."%') or lower(MODELO) like lower('%".$dato."%') limit ".$start.",".$end;

    return $this->db->execute($sql);    
   }
    function getProductoById($id){
        $sql="select * from productos where id=".$id;
        return $this->db->execute($sql);
    }
  


    function User_Login($username,$password){
      $sql="select * from clientes where username='".$username."' and password='".$password."'";
      $rs=$this->db->execute($sql);
      if(!$rs->EOF){
        return $rs->fields['id'];
      }else {
        return 0;
      }
    }
    /*FUNCIONES DE HOME*/
    function User_Data($id){
      $sql="select * from clientes where id=".$id;
      return $this->db->execute($sql);
    }
    function getNovedades($limit=4){
      $sql="select * from productos where novedad=1 and estado=1 order by rand() limit 0,".$limit;
      return $this->db->execute($sql);
    }

    function getProductosByCategoriaTotal($cat){
      $sql="select count(*) as total from productos,categorias_productos
            where productos.id = producto
            and estado=1
            and categorias_productos.categoria in (
            select id from subcategoria where subcategoria.categoria =".$cat."
            ) ";
      $rs=$this->db->execute($sql);
      return $rs->fields['total'];
    }
    function getProductosByCategoria($cat,$inicio,$fin){
      $sql="select * from productos where id in (select productos.id from productos,categorias_productos
            where productos.id = producto
            and estado=1
            and categorias_productos.categoria in (
            select id from subcategoria where subcategoria.categoria =".$cat."
            )) order by productos.id desc ";
      return $this->db->execute($sql);
    }
    function getProductosOfertas(){
      $sql="select * from productos where oferta=1 and estado = 1";
      return $this->db->execute($sql);
    }
    function getProductosBuscar($artista){
      $sql="select * from productos where lower(titulo) like lower('%".$artista."%') and estado = 1";
      return $this->db->execute($sql);
    }
    function getProductosBySubCategoriaTotal($subcat){
      $sql="select count(*) as total from productos
      where id in (
        select DISTINCT producto
        from categorias_productos
        where categorias_productos.categoria = ".$subcat.") and estado=1";
        $rs=$this->db->execute($sql);
      return $rs->fields['total'];
    }

    function getProductosBySubCategoria($subcat,$inicio,$fin){
      $sql="select * from productos
      where id in (
      select DISTINCT producto
      from categorias_productos
      where categorias_productos.categoria = ".$subcat.") and estado=1
        order by id desc ";
      return $this->db->execute($sql);
    }
    /*
      FUNCIONES CARRO
    */
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
public function agregaCarro($producto, $id_usuario,$color,$talla,$cantidad,$regalo,$imagen)
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
        $valor = "'" . mysql_real_escape_string($valor) . "'";
    }
    return $valor;
}
public function quitarCarro($carro){

    $insertSQL = "SELECT pagoID
                    FROM carro
                    WHERE id_carro =".$carro;
    $rs=$this->db->Execute($insertSQL);

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
function eliminaDelCarro($carro){
  $sql="delete from carro where id_carro= ".$carro;
  $this->db->Execute($sql);
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
        $sql="SELECT precio FROM productos WHERE id = ".$producto;
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
public function actualizaCarro($post){

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
}
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
    return $rs->fields['stock'];
}

public function descuentaStock($code,$cantidad){
    $this->db->execute("SET NAMES 'utf8'");
    $sql = "update productos set stock=(stock-".$cantidad.") where id = " . $code;
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
function getBannerHome($id=""){
      $sql="select * from blog where 1=1";
      if($id!=""){
        $sql.=" and id=".$id;
      }
      return $this->db->execute($sql);
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

function getFacturacionCliente($cliente,$pago){
    $sql="select * from cliente_factura where cliente=".$cliente. " and pago=".$pago;
    return $this->db->Execute($sql);
}
function getDetalleCompra($pago){
  $sql="select * from detalles_compra where pagoId = ".$pago;
  return $this->db->Execute($sql);
}
	function close(){
		$this->db->close();
	}

}

?>
