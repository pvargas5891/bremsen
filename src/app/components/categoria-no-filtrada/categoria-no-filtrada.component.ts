import { Component, OnInit, ViewChild} from '@angular/core';
import { InformacionService} from "../../services/informacion.service";
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from './detalleCatProductos';
import {CreateNewAutocompleteGroup, SelectedAutocompleteItem, NgAutocompleteComponent} from "ng-auto-complete";
import { CarroCompraService } from '../../services/carro-compra.service';
import { Router, NavigationEnd } from '@angular/router';
@Component({
  selector: 'app-categoria-no-filtrada',
  templateUrl: './categoria-no-filtrada.component.html',
})
export class CategoriaNoFiltradaComponent implements OnInit {

  public productos;
  public resultProductos;
  public p: number = 1;
  public itemsPerPage = 10;
  public mostrarLoading = true;
  public errorMessage: String;
  public totalStock: number = 10;
  //'Alta Seguridad (Runflat)', '4x4 (M/T)','Carretera (H/T)'
  public atributoRadio: string[] = [];
    //ncho| perfil | aro | indice - de - carga | marca | instalacion - gratis | despacho - gratis
    //'Oferta'
  public opcionesRadio: string[]=[];
  public detallesCategoria = new DetalleCatProductos();
  public marcaGroup = [];
  public modeloGroup = [];
  public anoGroup = [];
  public estadoCarro:boolean = false;
  public anchoGroup = [];
  public perfilGroup = [];
  public aroGroup = [];
  public cantidadValido = false;
  public cambiaCarro = false;
  constructor(private _productoService: ProductosService,
              public _is:InformacionService,
              private routeLink: Router,
              private _carroCompra: CarroCompraService) {

     this.detallesCategoria.inicio="1";
     this.detallesCategoria.fin="10";
     this.getProductosFiltrado();
     this.getMarcaVehiculos();
     this.getAnchoVehiculos();
      window.scrollTo(0, 0);
  }

    ngOnInit() {
        window.scrollTo(0, 0);
        this.routeLink.events.subscribe((evt) => {
            if (!(evt instanceof NavigationEnd)) {
                return;
            }
            window.scrollTo(0, 0)
        });
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
           //console.debug(data);
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
       console.debug(this.productos);
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
public mensajeSublime = false;
  public buscador1 = function(){
      this.detallesCategoria.ancho="";
      this.detallesCategoria.perfil="";
      this.detallesCategoria.aro="";
      this.detallesCategoria.origen=1;
      this.mensajeSublime=true;
     this.getProductosFiltrado();
  }
    public buscador2 = function(){
     this.detallesCategoria.marca="";
     this.detallesCategoria.modelo="";
     this.detallesCategoria.ano="";
     this.detallesCategoria.origen=2;
     this.getProductosFiltrado();
  }


  /** BUSCADOR ** */

    getAnchoVehiculos = function (){
    this._is.getAnchoVehiculos().then( data => {
        this.anchoGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];

        this.perfilGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
        this.aroGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);

  }
  getPerfilVehiculos = function (event: SelectedAutocompleteItem){

    this.detallesCategoria.ancho = event.item.title;
    this._is.getPerfilVehiculos(this.detallesCategoria.ancho).then( data => {
        this.perfilGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
  getAroVehiculos = function (event: SelectedAutocompleteItem){
      this.detallesCategoria.perfil = event.item.title;
      this._is.getAroVehiculos(this.detallesCategoria.perfil).then( data => {
      this.aroGroup = [
      CreateNewAutocompleteGroup(
          '',
          'completer',
          data,
          {titleKey: 'title', childrenKey: null}
          ),
      ];
      },
      error => this.errorMessage = <any>error);
  }
  setAroVehiculos = function (event: SelectedAutocompleteItem){
    this.detallesCategoria.aro = event.item.title;
  }


  getMarcaVehiculos = function (){
    this._is.getMarcaVehiculos().then( data => {
        this.marcaGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];

        this.modeloGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
        this.anoGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);

  }


   getModeloVehiculos = function (event: SelectedAutocompleteItem){

    this.detallesCategoria.marca = event.item.title;
    this._is.getModeloVehiculos(this.detallesCategoria.marca).then( data => {
        this.modeloGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
   getAnoVehiculos = function (event: SelectedAutocompleteItem){
    this.detallesCategoria.modelo = event.item.title;
    this._is.getAnoVehiculos(this.detallesCategoria.modelo).then( data => {
        this.anoGroup = [
        CreateNewAutocompleteGroup(
            '',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
  setAnoVehiculos = function (event: SelectedAutocompleteItem){
    this.detallesCategoria.ano = event.item.title;
  }
    public validaNombreRequerido= false;
    public validaEmailRequerido = false;
    public nombreEnviar = "";
    public emailEnviar = "";
    public mensajeDeEnviado = "";
  enviarDatosValida = function (){
      if (this.nombreEnviar==""){
        this.validaNombreRequerido=true;  
        return;
      }else{
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
             
              this.mensajeDeEnviado="Se ha enviado tus datos, te contactaremos a la brevedad";
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
              //document.getElementById("openModalButton").click();
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
