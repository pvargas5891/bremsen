import { Injectable } from '@angular/core';
import { Http, RequestOptions,Response, Headers  } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class CarroCompraService {

  url:string = 'http://bremsen.kodamas.cl/maqueta/';

  constructor( private http:Http) {

     // this.cargar_productos();

  }

  public agregarCarro = function (cantidad,producto, usuario): Promise<any>{

    let headers = new Headers({ 'Content-Type': 'application/json' });
    let options = new RequestOptions({ headers: headers });
    const params = new URLSearchParams();
    params.append('cantidad',cantidad);
    params.append('value',producto);
    params.append('usuario',usuario);

    return this.http.get(this.url+ 'agregarcarro.php?'+ params.toString(), options).toPromise()
            .then(this.extractData)
            .catch(this.handleErrorPromise);

  }

  public getCarroAll = function (usuario): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('usuario',usuario);

      return this.http.get(this.url+ 'productos.php?'+ params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }
}
