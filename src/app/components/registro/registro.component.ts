import { Component, OnInit } from '@angular/core';
import { InformacionService } from '../../services/informacion.service';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html'
})
export class RegistroComponent {
  public regionSeleccion: any[] = [];
  constructor(public _is: InformacionService) {
  
   }
  public cambiaCiudad(event){
    console.debug(this.regionSeleccion);
  }
}
