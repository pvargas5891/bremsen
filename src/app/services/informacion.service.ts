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
  constructor( public http:Http ) {

    this.getRegiones();
    this.getCiudades("1");
    this.getComunas("1");
  }

  public getCiudades(region:string ){

    this.http.get(this.url+"location.php?region=" + region)
             .subscribe( data =>{
              //console.debug(data.json());
               this.cargada = true;
               this.ciudades = data.json();

             })
  }
  public getComunas(ciudad:string) {

    this.http.get(this.url+"location.php?ciudad=" + ciudad)
      .subscribe(data => {
        //console.debug(data.json());
        this.cargada = true;
        this.comunas = data.json();
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
        // console.debug(this.regiones[0][0]);
        //console.debug(this.regiones[0][1]);
      })
  }

  public saveRegistroUser(registro: Cliente): Promise<string>{


        let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('nombreCompleto', registro.nombreCompleto);
        params.append('comuna', registro.comuna);
        params.append('ciudad', registro.ciudad);
        params.append('region', registro.region);
        params.append('direccion', registro.direccion);
        params.append('genero', registro.genero);
        params.append('telefono', registro.telefono);
        params.append('email', registro.email);
        let body = params.toString()
        return this.http.post(this.url+ 'registro.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);


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
