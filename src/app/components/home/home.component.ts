import { Component, OnInit } from '@angular/core';
import { InformacionService} from "../../services/informacion.service";
import { Router } from '@angular/router';

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

  constructor(
    public _is:InformacionService,
    private router: Router
  ) {}

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
}
