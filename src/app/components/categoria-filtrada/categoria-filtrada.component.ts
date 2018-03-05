import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from '../categoria-no-filtrada/detalleCatProductos';
import { CarroCompraService } from '../../services/carro-compra.service';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';

@Component({
  selector: 'app-categoria-filtrada',
  templateUrl: './categoria-filtrada.component.html',
  styles: []
})
export class CategoriaFiltradaComponent implements OnInit {

    public productos;
    errorMessage: String;
    public totalStock: number = 10;
    public atributoRadio: string[]=[];
    public opcionesRadio: string[]=[];
    public detallesCategoria = new DetalleCatProductos();
    public param1: string;
    public param2: string;
    public param3: string;
    public origen: string;
    public parametros;
    public estadoCarro:boolean = false;
    public resultProductos;
    public p: number = 1;
    public itemsPerPage = 10;
    public mostrarLoading = true;

  constructor(private route: ActivatedRoute,
              private routeLink: Router,
              private _productoService: ProductosService,
              private _carroCompra: CarroCompraService) {

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
          this.detallesCategoria.origen=parametros.origen;
      });

      this.detallesCategoria.inicio="1";
      this.detallesCategoria.fin="10";
      this.getProductosFiltrado();
    window.scrollTo(0, 0);

  }
  ngOnInit() {
    this.routeLink.events.subscribe((evt) => {
      if (!(evt instanceof NavigationEnd)) {
        return;
      }
      window.scrollTo(0, 0)
    });
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
         this.atributoRadio = data[2];
         this.opcionesRadio = data[3];

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
    if(atributo === 'all'){
        atributo = '';
      }
    this.detallesCategoria.atributo=atributo;
      this.getProductosFiltrado();
  }
  public filtroOpciones = function(opcion){
    if(opcion === 'all'){
        opcion = '';
      }
    this.detallesCategoria.opciones=opcion;
    this.getProductosFiltrado();
  }

public agregarCarroAnterior = function (indice,cantidad,producto) {

  //this.cantidadValido = false;
    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if(typeof cantidad == 'undefined'){
      this.cantidadValido=true;
      return;
    }

  if (currentUser == null) {

    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    console.debug(carroTemporal);
    if (carroTemporal == null) {
      var object = new Array();
      var carro = {
        id_producto: producto,
        cantidad: cantidad,
        id_carro:producto
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
      }
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
           if(indice == 1){
             this.routeLink.navigate(['/carro']);
           }
      },
      error => {

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
  
  public agregarCarro = function (indice,cantidad,producto) {

  //this.cantidadValido = false;
    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if(typeof cantidad == 'undefined'){
      this.cantidadValido=true;
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
          if(indice == 1){
               this.routeLink.navigate(['/carro']);
               //document.getElementById("openModalButton").click();
          }else{
             document.getElementById("openModalButton").click();
          }
          return;
      }

    var usuario = currentUser.usuario.id;
    this._carroCompra.agregarCarro(cantidad,producto, usuario)
    .then(
      data => {
        console.debug(data);
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
          var cambiaCarro = JSON.parse(localStorage.getItem('cambiaCarro'));
          if(indice == 1){
              this.routeLink.navigate(['/carro']);
             // document.getElementById("openModalButton").click();
          }else{
             document.getElementById("openModalButton").click();
          }

      },
      error => {
          console.debug(error);
      }
    );
  }
}
