import { Component, OnInit, ViewChild} from '@angular/core';
import { InformacionService} from "../../services/informacion.service";
import { Router } from '@angular/router';
import {CreateNewAutocompleteGroup, SelectedAutocompleteItem, NgAutocompleteComponent} from "ng-auto-complete";
//https://github.com/sengirab/ngAutocomplete
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html'
})
export class HomeComponent {

  marca: string = '';
  modelo: string = '';
  ano: string = '';

  ancho: string = '';
  perfil: string = '';
  aro: string = '';
  errorMessage: String;
  public marcaGroup = [];
  public modeloGroup = [];
  public anoGroup = [];

  public anchoGroup = [];
  public perfilGroup = [];
  public aroGroup = [];

   @ViewChild(NgAutocompleteComponent) public completer: NgAutocompleteComponent;



  constructor(
    public _is:InformacionService,
    private router: Router
  ) {
    this.getMarcaVehiculos();
    this.getAnchoVehiculos();
  }

  btnBuscarClick= function (origen:number) {
      console.debug("ejecutado");
      let param1:string = this.marca;
      let param2:string = this.modelo;
      let param3:string = this.ano;
      if(origen==2){
         param1 = this.ancho;
         param2 = this.perfil;
         param3 = this.aro;
      }
      this.router.navigateByUrl('/filtrada/'+param1+"/"+param2+"/"+param3+"/"+origen);
  };
  btnRegistro = function (){
    this.router.navigateByUrl('/registro');
  }

  getAnchoVehiculos = function (){
    this._is.getAnchoVehiculos().then( data => {
        this.anchoGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el ancho de la rueda',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];

        this.perfilGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el perfil de la rueda',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
        this.aroGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el aro de la rueda',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);

  }
  getPerfilVehiculos = function (event: SelectedAutocompleteItem){

    this.ancho = event.item.title;
    this._is.getPerfilVehiculos(this.ancho).then( data => {
        this.perfilGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el perfil de la rueda',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
  getAroVehiculos = function (event: SelectedAutocompleteItem){
      this.perfil = event.item.title;
      this._is.getAroVehiculos(this.perfil).then( data => {
      this.aroGroup = [
      CreateNewAutocompleteGroup(
          'Seleccione el aro de la rueda',
          'completer',
          data,
          {titleKey: 'title', childrenKey: null}
          ),
      ];
      },
      error => this.errorMessage = <any>error);
  }
  setAroVehiculos = function (event: SelectedAutocompleteItem){
    this.aro = event.item.title;
  }


  getMarcaVehiculos = function (){
    this._is.getMarcaVehiculos().then( data => {
        this.marcaGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione su marca de vehiculo',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];

        this.modeloGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el modelo de vehiculo',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
        this.anoGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el modelo de vehiculo',
            'completer',
            [],
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);

  }


   getModeloVehiculos = function (event: SelectedAutocompleteItem){

    this.marca = event.item.title;
    this._is.getModeloVehiculos(this.marca).then( data => {
        this.modeloGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el modelo de vehiculo',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
   getAnoVehiculos = function (event: SelectedAutocompleteItem){
    this.modelo = event.item.title;
    this._is.getAnoVehiculos(this.modelo).then( data => {
        this.anoGroup = [
        CreateNewAutocompleteGroup(
            'Seleccione el modelo de vehiculo',
            'completer',
            data,
            {titleKey: 'title', childrenKey: null}
            ),
        ];
		    },
        error => this.errorMessage = <any>error);
  }
  setAnoVehiculos = function (event: SelectedAutocompleteItem){
    this.ano = event.item.title;
  }
}
