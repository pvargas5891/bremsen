import { Injectable } from '@angular/core';
import { Http, RequestOptions,Response, Headers  } from '@angular/http';
import { Observable } from 'rxjs';
import { DetalleCatProductos } from '../components/categoria-no-filtrada/detalleCatProductos';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
@Injectable()
export class ProductosService {

  url:string = 'http://bremsen.kodamas.cl/maqueta/';

  constructor( private http:Http) {

     // this.cargar_productos();

  }

  public getProductos(detalleCatProductos: DetalleCatProductos): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();

      params.append('inicio', detalleCatProductos.inicio);
      params.append('fin', detalleCatProductos.fin);
      params.append('order', detalleCatProductos.order);
      params.append('marca', detalleCatProductos.marca);
      params.append('atributo', detalleCatProductos.atributo);
      params.append('opciones', detalleCatProductos.opciones);
      params.append('modelo', detalleCatProductos.modelo);
      params.append('ano', detalleCatProductos.ano);
      params.append('ancho', detalleCatProductos.ancho);
      params.append('perfil', detalleCatProductos.perfil);
      params.append('aro', detalleCatProductos.aro);

      let body = params.toString();
      //console.debug(body);
      return this.http.get(this.url+ 'productos.php?' + body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }

  public getDetalleProductos(): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      return this.http.get(this.url+ 'productos.php?totalProductos=1', options).toPromise()
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
