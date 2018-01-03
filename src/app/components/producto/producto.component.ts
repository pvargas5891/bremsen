import { Component,OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { ActivatedRoute } from '@angular/router';
import { CarroCompraService } from '../../services/carro-compra.service';
import { Producto} from "./producto";
import { DomSanitizer } from '@angular/platform-browser';
@Component({
  selector: 'app-producto',
  templateUrl: './producto.component.html',
  styles: []
})
export class ProductoComponent implements OnInit{

public producto = new Producto();
public parametros;
public cantidad=4;
public cantidadValido= false;
public estadoCarro:boolean = false;
public errorMessage: string;

public totalAComprar:number = 0;
  constructor(private route: ActivatedRoute,
              private _productoService: ProductosService,
              private _carroCompra: CarroCompraService,
              private sanitizer: DomSanitizer) {





}
    ngOnInit() {
       this.route.params.subscribe( parametros =>{
          //console.debug(parametros);
          this.parametros = parametros;
          this.getProductoById();
      });
  }
public sanitizaUrlExtern(url){
  return this.sanitizer.bypassSecurityTrustResourceUrl(url);
}
public getProductoById = function (){

    this._productoService.getProductosById(this.parametros.id)
	     .then( data => {
            console.debug(data);
            this.producto.ID = data[0].ID;
            this.producto.CODIGO = data[0].CODIGO;
            this.producto.MARCA = data[0].MARCA;
            this.producto.MODELO = data[0].MODELO;
            this.producto.MEDIDA = data[0].MEDIDA;
            this.producto.CATEGORIA = data[0].CATEGORIA;
            this.producto.ANCHO = data[0].ANCHO;
            this.producto.PERFIL = data[0].PERFIL;
            this.producto.ARO = data[0].ARO;
            this.producto.CARGA = data[0].CARGA;
            this.producto.LARGO = data[0].LARGO;
            this.producto.ALTO = data[0].ALTO;
            this.producto.PESO = data[0].PESO;
            this.producto.NETO = data[0].NETO;
            this.producto.UNITARIO = data[0].UNITARIO;
            this.producto.VALOR_INSTALACION = data[0].VALOR_INSTALACION;
            this.producto.TOTAL = data[0].TOTAL;
            this.producto.MC = data[0].MC;
            this.producto.NETO2 = data[0].NETO2;
            this.producto.PRECIO_FINAL = data[0].PRECIO_FINAL;
            this.totalAComprar = this.producto.PRECIO_FINAL * this.cantidad;
            this.producto.PRECIO_OFERTA = data[0].PRECIO_OFERTA;
            this.producto.JPG = data[0].JPG;
            this.producto.TITULO = data[0].TITULO;
            this.producto.ATRIBUTOS = data[0].ATRIBUTOS;
            this.producto.DESCRIPCION = data[0].DESCRIPCION;
            this.producto.LOGO = data[0].LOGO;
            this.producto.INCLUYE_INSTALACION = data[0].INCLUYE_INSTALACION;
            this.producto.DESPACHO = data[0].DESPACHO;
            this.producto.ULTIMOS_DIAS = data[0].ULTIMOS_DIAS;
            this.producto.RUNFLAT = data[0].RUNFLAT;
            this.producto.OFERTA = data[0].OFERTA;
            this.producto.ALTO_DESEMPENO = data[0].ALTO_DESEMPENO;
            this.producto.VIDEO = this.sanitizaUrlExtern(data[0].VIDEO);
            this.producto.STOCK = data[0].STOCK;
		    },
        error => this.errorMessage = <any>error);

}
public cambiaCantidad= function (cantidad){
      this.totalAComprar = parseInt(this.producto.PRECIO_FINAL) * parseInt(cantidad);
}
public agregarCarro = function (indice) {
  this.cantidadValido = false;
    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if(typeof this.cantidad == 'undefined'){
      this.cantidadValido = true;
      return;
    }

    var cantidad = this.cantidad;



      if (currentUser == null) {

        var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
        console.debug(carroTemporal);
        if (carroTemporal == null) {
          var object = new Array();
          var carro = {
            id_producto: producto,
            cantidad: cantidad,
            id_carro: producto
          };
          object.push(carro);
          localStorage.setItem('carroUserTemporal', JSON.stringify(object));
        } else {
          var existe = false;

          for (var i = 0; i < carroTemporal.length; i++) {
            if (carroTemporal[i].id_producto == producto) {
              carroTemporal[i].cantidad = parseInt(carroTemporal[i].cantidad) + parseInt(cantidad);
              existe = true;
            }
          }
          if (!existe) {
            var carro = {
              id_producto: producto,
              cantidad: cantidad,
              id_carro: producto
            };
            carroTemporal.push(carro);
          }

          localStorage.setItem('carroUserTemporal', JSON.stringify(carroTemporal));
        }
        var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));

        localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
        if(indice == 1){
              this.routeLink.navigate(['/carro']);
              document.getElementById("openModalButton").click();
          }else{
             document.getElementById("openModalButton").click();
          }
        return;
      }



    var usuario = currentUser.usuario.id;
    var producto = this.producto.ID;
    this._carroCompra.agregarCarro(cantidad,producto, usuario)
    .then(
      data => {
          if(data=='STOCK'){
            this.errorMessage = 'No hay stock suficiente para tu pedido';
            return;
          }
          if(data=='STOCKTEMP'){
            this.errorMessage = 'No hay stock suficiente para tu pedido';
            return;
          }
          this.estadoCarro = true;
        localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
         if(indice == 1){
              this.routeLink.navigate(['/carro']);
              document.getElementById("openModalButton").click();
          }else{
             document.getElementById("openModalButton").click();
          }
      },
      error => {

      }
    );

}

/*


$general2['ID']=$rs->fields['id'];
			$general2['CODIGO']=$rs->fields['CODIGO'];
			$general2['MARCA']=$rs->fields['Marca'];
			$general2['MODELO']=$rs->fields['MODELO'];
			$general2['MEDIDA']=$rs->fields['MEDIDA'];
			$general2['CATEGORIA']=$rs->fields['CATEGORIA'];
			$general2['ANCHO']=$rs->fields['ANCHO'];
			$general2['PERFIL']=$rs->fields['PERFIL'];
			$general2['ARO']=$rs->fields['ARO'];
			$general2['CARGA']=$rs->fields['Carga'];
			$general2['LARGO']=$rs->fields['LARGO'];
			$general2['ALTO']=$rs->fields['ALTO'];
			$general2['PESO']=$rs->fields['Peso'];
			$general2['NETO']=$rs->fields['neto'];
			$general2['UNITARIO']=$rs->fields['unitario'];
			$general2['VALOR_INSTALACION']=$rs->fields['VALOR_INSTALACION'];
			$general2['TOTAL']=$rs->fields['total'];
			$general2['MC']=$rs->fields['MC'];
			$general2['NETO2']=$rs->fields['neto2'];
			$general2['PRECIO_FINAL']=$rs->fields['precio_final'];
			$general2['PRECIO_OFERTA']=$rs->fields['precio_oferta'];
			//$general2['MODELO']=$rs->fields['MODELO'];
			$general2['JPG']=$rs->fields['JPG'];
			$general2['TITULO']=$rs->fields['TITULO'];
			$general2['ATRIBUTOS']=$rs->fields['ATRIBUTOS'];
			$general2['DESCRIPCION']=$rs->fields['DESCRIPCION'];
			$general2['LOGO']=$rs->fields['Logo'];
			$general2['INCLUYE_INSTALACION']=$rs->fields['INCLUYE_INSTALACION'];
			$general2['DESPACHO']=$rs->fields['DESPACHO'];
			$general2['ULTIMOS_DIAS']=$rs->fields['ultimos_dias'];
			$general2['RUNFLAT']=$rs->fields['RUNFLAT'];
			$general2['OFERTA']=$rs->fields['OFERTA'];
      $general2['ALTO_DESEMPENO']=$rs->fields['alto_desempeno'];

*/


}
