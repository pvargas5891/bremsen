import { Component, OnInit, ViewChild} from '@angular/core';
import { InformacionService} from "../../services/informacion.service";
import { ProductosService } from '../../services/productos.service';
import { DetalleCatProductos } from './detalleCatProductos';
import {CreateNewAutocompleteGroup, SelectedAutocompleteItem, NgAutocompleteComponent} from "ng-auto-complete";

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

  public marcaGroup = [];
  public modeloGroup = [];
  public anoGroup = [];

  public anchoGroup = [];
  public perfilGroup = [];
  public aroGroup = [];

  constructor(private _productoService: ProductosService,
              public _is:InformacionService) {

     this.detallesCategoria.inicio="1";
     this.detallesCategoria.fin="10";
     this.getProductosFiltrado();
     this.getMarcaVehiculos();
     this.getAnchoVehiculos();
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
        console.debug(this.productos);
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

  public buscador1 = function(){
      this.detallesCategoria.ancho="";
      this.detallesCategoria.perfil="";
      this.detallesCategoria.aro="";
      this.detallesCategoria.origen=1;
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

}
