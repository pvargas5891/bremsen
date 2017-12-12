import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from '../categoria-no-filtrada/detalleCatProductos';

import { ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-categoria-filtrada',
  templateUrl: './categoria-filtrada.component.html',
  styles: []
})
export class CategoriaFiltradaComponent {

    public productos;
    errorMessage: String;
    public totalStock: number = 10;
    public atributoRadio: string[]=['4x4','Runflat','Oferta','Carretera'];
    public opcionesRadio: string[]=['Ofertas'];
    public detallesCategoria = new DetalleCatProductos();
    public param1: string;
    public param2: string;
    public param3: string;
    public origen: string;
    public parametros;

    public resultProductos;
    public p: number = 1;
    public itemsPerPage = 10;
    public mostrarLoading = true;

  constructor(private route: ActivatedRoute,
              private _productoService: ProductosService) {

      route.params.subscribe( parametros =>{
          //console.debug(parametros);
          this.parametros = parametros;
          this.param1=(parametros.param1!='undefined')?parametros.param1:'';
          this.param2=(parametros.param2!='undefined')?parametros.param2:'';;
          this.param3=(parametros.param3!='undefined')?parametros.param3:'';;
          this.origen=parametros.origen;

          if(parametros.origen=='1'){
             this.detallesCategoria.marca=parametros.param1;
             this.detallesCategoria.modelo=parametros.param2;
             this.detallesCategoria.ano=parametros.param3;
          }else{
             this.detallesCategoria.ancho=parametros.param1;
             this.detallesCategoria.perfil=parametros.param2;
             this.detallesCategoria.aro=parametros.param3;
          }

      });

      this.detallesCategoria.inicio="1";
      this.detallesCategoria.fin="10";
      this.getProductosFiltrado();

  }

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


}
