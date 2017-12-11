import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from './detalleCatProductos';
@Component({
  selector: 'app-categoria-no-filtrada',
  templateUrl: './categoria-no-filtrada.component.html',
  styles: []
})
export class CategoriaNoFiltradaComponent {

  public productos;
  errorMessage: String;
  public totalStock: number = 10;
  public atributoRadio: string[]=['Run flat','Carga pesada','Eco'];
  public opcionesRadio: string[]=['Ofertas','Pack','Instalación Rapida'];
  public detallesCategoria = new DetalleCatProductos();


  constructor(private _productoService: ProductosService) {

     this.detallesCategoria.inicio="1";
     this.detallesCategoria.fin="10";
     this.getProductos();

  }
  public getProductos = function (){

       this._productoService.getDetalleProductos()
	     .then( data => {
           // console.debug(data);
            this.detallesCategoria.totalProductos = data[0].TOTALPRODUCTOS;
            this.detallesCategoria.todasMarcas=data[1];

		    },
        error => this.errorMessage = <any>error);


   this._productoService.getProductos(this.detallesCategoria)
	     .then( data => {
            //console.debug(data);
            this.productos = data;
		    },
        error => this.errorMessage = <any>error);

  }
  public ordenadorProductos = function(){
     this.getProductos();
  }
  public filtroMarca= function(marcaSeleccion){
      //console.debug(marcaSeleccion);
      this.detallesCategoria.marca=marcaSeleccion;
      this.getProductos();
  }
  public filtroAtributo = function(atributo){
    this.detallesCategoria.atributo=atributo;
      this.getProductos();
  }
  public filtroOpciones = function(opcion){
    this.detallesCategoria.opcion=opcion;
    this.getProductos();
  }
  public buscador1 = function(){
      this.detallesCategoria.ancho="";
      this.detallesCategoria.perfil="";
      this.detallesCategoria.aro="";
     this.getProductos();
  }
    public buscador2 = function(){
     this.detallesCategoria.marca="";
     this.detallesCategoria.modelo="";
     this.detallesCategoria.ano="";
     this.getProductos();
  }
}
