import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from '../categoria-no-filtrada/detalleCatProductos';
import { CarroCompraService } from '../../services/carro-compra.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styles: []
})
export class SearchComponent {

    public productos;
    errorMessage: String;
    public totalStock: number = 10;
  //'Alta Seguridad (Runflat)', '4x4 (M/T)','Carretera (H/T)'
  public atributoRadio: string[] = [];
    //ncho| perfil | aro | indice - de - carga | marca | instalacion - gratis | despacho - gratis
    //'Oferta'
  public opcionesRadio: string[]=[];
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
              private routeLink: Router,
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
            if(this.origen=='home'){
              if(this.param1=='camioneta'){
                this.param1="Camioneta (M/T)";
                this.detallesCategoria.atributo=this.param1;                
              }
              if(this.param1=='automovil'){
                this.param1="Automovil (H/T)";
                this.detallesCategoria.atributo=this.param1;
              }
              if(this.param1=='runflat'){
                this.param1="Alta Seguridad (Runflat)";
                this.detallesCategoria.atributo=this.param1;
              }
              if (this.param1 == 'ofertas') {
                this.param1 = "Oferta";
                this.detallesCategoria.opciones = this.param1;
              }
              this.detallesCategoria.origen='undefined';
            }else{
              this.detallesCategoria.origen=this.param1;
            }
             
          }

      });

      this.detallesCategoria.inicio="1";

      this.detallesCategoria.fin="10";
      this.getProductosFiltrado();
    window.scrollTo(0, 0);
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
            this.atributoRadio =data[2];
            this.opcionesRadio=data[3];
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

  public agregarCarro = function (indice, cantidad, producto) {

    //this.cantidadValido = false;
    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if (typeof cantidad == 'undefined') {
      this.cantidadValido = true;
      return;
    }



    if (currentUser == null) {

      var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));

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
      if (indice == 1) {
        this.routeLink.navigate(['/carro']);
        //document.getElementById("openModalButton").click();
      } else {
        document.getElementById("openModalButton").click();
      }
      return;
    }

    var usuario = currentUser.usuario.id;
    this._carroCompra.agregarCarro(cantidad, producto, usuario)
      .then(
        data => {
          console.debug(data);
          if (data == 'STOCK') {
            this.errorMessage = 'No hay stock suficiente para tu pedido';
            return;
          }
          if (data == 'STOCKTEMP') {
            this.errorMessage = 'No hay stock suficiente para tu pedido';
            return;
          }

          this.estadoCarro = true;
          localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
          var cambiaCarro = JSON.parse(localStorage.getItem('cambiaCarro'));
          if (indice == 1) {
            this.routeLink.navigate(['/carro']);
            // document.getElementById("openModalButton").click();
          } else {
            document.getElementById("openModalButton").click();
          }

        },
        error => {
          console.debug(error);
        }
      );
  }

  public validaNombreRequerido = false;
  public validaEmailRequerido = false;
  public nombreEnviar = "";
  public emailEnviar = "";
  public mensajeDeEnviado = "";
  enviarDatosValida = function () {
    if (this.nombreEnviar == "") {
      this.validaNombreRequerido = true;
      return;
    } else {
      this.validaNombreRequerido = false;
    }

    if (this.emailEnviar == "") {
      this.validaEmailRequerido = true;
      return;
    } else {
      this.validaEmailRequerido = false;
    }

    this._productoService.solicitaProductos(this.nombreEnviar, this.emailEnviar)
      .then(data => {

        this.mensajeDeEnviado = "Se ha enviado tus datos, te contactaremos a la brevedad";
      },
        error => this.errorMessage = <any>error);
  }
  
}
