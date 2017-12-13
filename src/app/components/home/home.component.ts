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

   @ViewChild(NgAutocompleteComponent) public completer: NgAutocompleteComponent;

    public group = [
        CreateNewAutocompleteGroup(
            'Search / choose in / from list',
            'completer',
            [
                {title: 'Option 1', id: '1'},
                {title: 'Option 2', id: '2'},
                {title: 'Option 3', id: '3'},
                {title: 'Option 4', id: '4'},
                {title: 'Option 5', id: '5'},
            ],
            {titleKey: 'title', childrenKey: null}
        ),
    ];

  constructor(
    public _is:InformacionService,
    private router: Router
  ) {

    this.getMarcaVehiculos();

  }

  btnBuscarClick= function (origen:number) {
      //console.debug(this.router);
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
  getMarcaVehiculos = function (){
    this._is.getMarcaVehiculos();
    return this._is.marcas;
  }
   getModeloVehiculos = function (event){
     console.debug(event);
     if(this.marca=='undefined')
        return;
    this._is.getModeloVehiculos(this.marca);
    return this._is.modelos;
  }
   getAnoVehiculos = function (){
     if(this.modelo=='undefined')
        return;
    this._is.getAnoVehiculos(this.modelo);
    return this._is.anos;
  }
}
