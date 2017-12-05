import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

@Injectable()
export class InformacionService {

  info:any = {};
  cargada:boolean = false;
  cargada_sobre_nosotros:boolean = false;
  equipo:any[] = [];
  public regiones: any[] = [];
  public ciudades: any[] = [];
  public comunas:any[] = [];
  constructor( public http:Http ) {

    this.getRegiones();

  }

  public getCiudades(ciudad){
    
    this.http.get("http://bremsen.kodamas.cl/maqueta/location.php?ciudad=" + ciudad)
             .subscribe( data =>{
              //console.debug(data.json());
               this.cargada = true;
               this.ciudades = data.json();
             })
  }
  public getComunas(comuna) {

    this.http.get("http://bremsen.kodamas.cl/maqueta/location.php?comuna" + comuna)
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.comunas = data.json();
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }
  public getRegiones() {

    this.http.get("http://bremsen.kodamas.cl/maqueta/location.php")
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.regiones = data.json();
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }

}
