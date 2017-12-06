import { Injectable } from '@angular/core';
import { Http, RequestOptions,Response, Headers  } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
@Injectable()
export class ProductosService {

  url:string = 'http://bremsen.kodamas.cl/maqueta/';

  constructor( private http:Http) {

     // this.cargar_productos();

  }

  public getProductos(): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      return this.http.get(this.url+ 'productos.php', options).toPromise()
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
