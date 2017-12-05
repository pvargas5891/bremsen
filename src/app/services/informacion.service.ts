import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

@Injectable()
export class InformacionService {

  info:any = {};
  cargada:boolean = false;
  cargada_sobre_nosotros:boolean = false;
  equipo:any[] = [];
  regiones:any[] = [];
  constructor( public http:Http ) {

    this.carga_info();
    this.carga_sobre_nosotros();
    this.getRegiones();

  }

  public carga_info(){
     /*this.http.get("assets/data/info.paginas.json")
             .subscribe( data =>{
              // console.debug(data.json());
               this.cargada = true;
               this.info = data.json();
             })*/
  }
  public getRegiones(){
    
    this.http.get("http://bremsen.kodamas.cl/maqueta/location.php")
             .subscribe( data =>{
              console.debug(data.json());
               this.cargada = true;
               this.regiones = data.json();
               console.debug(this.regiones[0][0]);
               console.debug(this.regiones[0][1]);
             })
  }
  public carga_sobre_nosotros(){

      /* this.http.get("https://bremsen-d8cc6.firebaseio.com/equipo.json")
             .subscribe( data =>{
              console.debug(data.json());
              this.cargada_sobre_nosotros = true;
               this.equipo = data.json();
             })*/

  }

}
