import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from './detalleCatProductos';
@Component({
  selector: 'app-categoria-no-filtrada',
  templateUrl: './categoria-no-filtrada.component.html',
  styles: []
})
export class CategoriaNoFiltradaComponent {

  public productos: string[]=[];
  public resultProductos;
  public p: number = 1;
  public itemsPerPage = 10;
  public mostrarLoading = true;
  errorMessage: String;
  public totalStock: number = 10;
  public atributoRadio: string[]=['4x4','Runflat','Oferta','Carretera'];
  public opcionesRadio: string[]=['Ofertas'];
  public detallesCategoria = new DetalleCatProductos();


  constructor(private _productoService: ProductosService) {

     this.detallesCategoria.inicio="1";
     this.detallesCategoria.fin="10";
     this.getProductosFiltrado();

  }
  /*public getProductos = function (){

       this._productoService.getDetalleProductos()
	     .then( data => {
           // console.debug(data);
            this.detallesCategoria.totalProductos = data[0].TOTALPRODUCTOS;
            this.detallesCategoria.todasMarcas=data[1];

		    },
        error => this.errorMessage = <any>error);


   this._productoService.getProductos()
	     .then( data => {
            //console.debug(data);
            this.productos = data;
		    },
        error => this.errorMessage = <any>error);

  }*/

  public getProductosFiltrado = function (){
      this.mostrarLoading = true;
       this._productoService.getDetalleProductosFiltrado(this.detallesCategoria)
	     .then( data => {
           // console.debug(data);
            this.detallesCategoria.totalProductos = data[0].TOTALPRODUCTOS;
            this.detallesCategoria.todasMarcas=data[1];

		    },
        error => this.errorMessage = <any>error);


   this._productoService.getProductosFiltrado(this.detallesCategoria)
	     .then( data => {
            //console.debug(data);
            this.resultProductos = data;
            this.productosAMostrar();
            this.mostrarLoading = false;
		    },
        error => this.errorMessage = <any>error);

  }
  public productosAMostrar = function(){
        this.productos = [];
        for(let i = this.detallesCategoria.inicio; i <= this.detallesCategoria.fin;i++){
            this.productos.push(this.resultProductos[i-1]);
        }
  }
  public pageChanged = function (event){
      //this.p = event;
      if(event>this.p){
         this.detallesCategoria.inicio=parseInt(this.detallesCategoria.inicio)+parseInt(this.itemsPerPage);
         this.detallesCategoria.fin=parseInt(this.detallesCategoria.fin)+parseInt(this.itemsPerPage);
         if(this.detallesCategoria.fin>this.resultProductos.length){
           this.detallesCategoria.fin=this.resultProductos.length;
         }
      }else{

         this.detallesCategoria.inicio=parseInt(this.detallesCategoria.inicio)-parseInt(this.itemsPerPage);
         this.detallesCategoria.fin=parseInt(this.detallesCategoria.fin)-parseInt(this.itemsPerPage);
      }
      this.p = event;
      this.productosAMostrar();
  }
  public ordenadorProductos = function(){
     this.getProductosFiltrado();
  }
  public filtroMarca= function(marcaSeleccion){
      //console.debug(marcaSeleccion);
      this.detallesCategoria.marcaFiltro=marcaSeleccion;
      this.getProductosFiltrado();
  }
  public filtroAtributo = function(atributo){
    this.detallesCategoria.atributo=atributo;
      this.getProductosFiltrado();
  }
  public filtroOpciones = function(opcion){
    this.detallesCategoria.opcion=opcion;
    this.getProductosFiltrado();
  }

  public buscador1 = function(){
      this.detallesCategoria.ancho="";
      this.detallesCategoria.perfil="";
      this.detallesCategoria.aro="";
     this.getProductosFiltrado();
  }
    public buscador2 = function(){
     this.detallesCategoria.marca="";
     this.detallesCategoria.modelo="";
     this.detallesCategoria.ano="";
     this.getProductosFiltrado();
  }
}
