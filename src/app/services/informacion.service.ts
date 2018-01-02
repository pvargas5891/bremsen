import { Injectable } from '@angular/core';
import { Http, RequestOptions,Response, Headers  } from '@angular/http';
import { Cliente } from '../components/registro/cliente';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class InformacionService {

  info:any = {};
  cargada:boolean = false;
  //url:string = 'http://localhost:90/servidor/';
  url:string = 'http://bremsen.kodamas.cl/maqueta/';
  public regiones: any[] = [];
  public ciudades: any[] = [];
  public comunas:any[] = [];

  public regionesPersona: any[] = [];
  public ciudadesPersona: any[] = [];
  public comunasPersona:any[] = [];

  public regionesEmpresa: any[] = [];
  public ciudadesEmpresa: any[] = [];
  public comunasEmpresa:any[] = [];

  public marcas:any[] = [];
  public modelos:any[] = [];
  public anos:any[] = [];

  public anchos:any[] = [];
  public perfiles:any[] = [];
  public aros:any[] = [];

  public talleres: any[]=[];

  constructor( public http:Http ) {

    this.getRegiones();
    this.getCiudades("1");
    this.getComunas("1");

    //this.getVehiculos(1);
  }

  public getMarcaVehiculos(): Promise<string> {

    return this.http.get(this.url+"vehiculos.php?accion=marca").toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }
public getModeloVehiculos(marca): Promise<string>{

   return this.http.get(this.url+"vehiculos.php?accion=modelo&marca="+marca)
             .toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }
  public getAnoVehiculos(modelo): Promise<string>{

   return this.http.get(this.url+"vehiculos.php?accion=ano&modelo="+modelo)
            .toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }

   public getAnchoVehiculos(): Promise<string> {

    return this.http.get(this.url+"vehiculos.php?accion=ancho").toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }
public getPerfilVehiculos(ancho): Promise<string>{

   return this.http.get(this.url+"vehiculos.php?accion=perfil&ancho="+ancho)
             .toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }
  public getAroVehiculos(perfil): Promise<string>{

   return this.http.get(this.url+"vehiculos.php?accion=aro&perfil="+perfil)
            .toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }

  public getCiudades(region:string ){

    this.http.get(this.url+"location.php?region=" + region)
             .subscribe( data =>{
              //console.debug(data.json());
               this.cargada = true;
               this.ciudades = data.json();
               this.ciudadesPersona = data.json();
               this.ciudadesEmpresa = data.json();

             })
  }

  public getComunas(ciudad:string) {

    this.http.get(this.url+"location.php?ciudad=" + ciudad)
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.comunas = data.json();
        this.comunasPersona = data.json();
        this.comunasEmpresa = data.json();
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }
  public getRegiones() {

    this.http.get(this.url+"location.php")
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.regiones = data.json();
        this.regionesPersona = data.json();
        this.regionesEmpresa = data.json();

        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }
public getCiudadesEmpresa(region:string ){

    this.http.get(this.url+"location.php?region=" + region)
             .subscribe( data =>{
              //console.debug(data.json());
               this.cargada = true;
               this.ciudadesEmpresa = data.json();

             })
  }

  public getTalleresByRegion(region:string ){

    this.http.get(this.url+"talleres.php?region=" + region)
             .subscribe( data =>{
              //console.debug(data.json());
               this.cargada = true;
               this.talleres = data.json();

             })
  }

  public getComunasEmpresa(ciudad:string) {

    this.http.get(this.url+"location.php?ciudad=" + ciudad)
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.comunasEmpresa = data.json();
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }
  public getRegionesEmpresa() {

    this.http.get(this.url+"location.php")
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.regionesEmpresa = data.json();
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }

  private extractData(res: Response) {
        //console.debug(res);
        let body = res.json();
              //console.debug(body);
        return body;
    }

    private handleErrorPromise (error: Response | any) {
	    return Promise.reject(error.message || error);
    }

}
