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
      params.append('value',usuario);

      return this.http.get(this.url+ 'getcarro.php?'+ params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }
  public actualizaCarro= function(idCarro, cantidad): Promise<any>{
      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('idcarro',idCarro);
      params.append('cantidad',cantidad);
      params.append('accion','actualiza');

      return this.http.get(this.url+ 'updatecarro.php?'+ params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }
  public eliminaCarro = function(idCarro): Promise<any>{
let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('idcarro',idCarro);
      params.append('accion','elimina');
      return this.http.get(this.url+ 'updatecarro.php?'+ params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }
  private extractData(res: Response) {
        //console.debug(res);
        let body = res.json();
         // console.debug(body);
        return body;
    }

    private handleErrorPromise (error: Response | any) {
	    return Promise.reject(error.message || error);
    }
}
