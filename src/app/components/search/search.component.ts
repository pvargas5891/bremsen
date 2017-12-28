import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from '../categoria-no-filtrada/detalleCatProductos';
import { CarroCompraService } from '../../services/carro-compra.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styles: []
})
export class SearchComponent {

    public productos;
    errorMessage: String;
    public totalStock: number = 10;
    public atributoRadio: string[]=['4x4','Runflat','Oferta','Carretera'];
    public opcionesRadio: string[]=['Ofertas'];
    public detallesCategoria = new DetalleCatProductos();
    public param1: string;
    public origen: string;
    public parametros;
    public estadoCarro:boolean = false;
    public resultProductos;
    public p: number = 1;
    public itemsPerPage = 10;
    public mostrarLoading = true;

  constructor(private route: ActivatedRoute,
              private _productoService: ProductosService,
              private _carroCompra: CarroCompraService) {

      route.params.subscribe( parametros =>{
          //console.debug(parametros);
          this.parametros = parametros;
          this.param1=parametros.data;
          this.origen=parametros.origen;
          this.detallesCategoria.origen=this.origen;
          if(parametros.origen=='marca'){
             this.detallesCategoria.marcaFiltro=this.param1;
          }else{
             this.detallesCategoria.origen=this.param1;
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
            console.debug(data);
            this.detallesCategoria.totalProductos = data[0].TOTALPRODUCTOS;
            if(this.detallesCategoria.totalProductos<this.itemsPerPage){
              this.detallesCategoria.fin=this.detallesCategoria.totalProductos;
            }
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
     // console.debug(event);
     // console.debug(this.detallesCategoria.inicio +" - "+this.detallesCategoria.fin);
      this.detallesCategoria.inicio=1;
      this.detallesCategoria.fin=this.itemsPerPage;
      for(let i=1;i < event; i++){
        this.detallesCategoria.inicio=parseInt(this.detallesCategoria.inicio)+parseInt(this.itemsPerPage);
         this.detallesCategoria.fin=parseInt(this.detallesCategoria.fin)+parseInt(this.itemsPerPage);
      }
      if(this.detallesCategoria.fin>this.resultProductos.length){
           this.detallesCategoria.fin=this.resultProductos.length;
      }
      /*if(event>this.p){

         if(this.detallesCategoria.fin>this.resultProductos.length){
           this.detallesCategoria.fin=this.resultProductos.length;
         }
      }else{

         this.detallesCategoria.inicio=parseInt(this.detallesCategoria.inicio)-parseInt(this.itemsPerPage);
         this.detallesCategoria.fin=parseInt(this.detallesCategoria.fin)-parseInt(this.itemsPerPage);
      }*/
      this.p = event;
      //console.debug(this.detallesCategoria.inicio +" - "+this.detallesCategoria.fin);
      this.productosAMostrar();
  }
  public ordenadorProductos = function(){
     this.getProductosFiltrado();
  }
  public filtroMarca= function(marcaSeleccion){
      //console.debug(marcaSeleccion);
      if(marcaSeleccion === 'all'){
        marcaSeleccion = '';
      }
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

public agregarCarro = function (indice,cantidad,producto) {

  //this.cantidadValido = false;
    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if(typeof cantidad == 'undefined'){
      this.cantidadValido=true;
      return;
    }

    var usuario = currentUser.usuario.id;
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
      },
      error => {

      }
    );
  }
}
