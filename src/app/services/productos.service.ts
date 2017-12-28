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
  private getParametrosBusquedas(detalleCatProductos: DetalleCatProductos): URLSearchParams{

      const params = new URLSearchParams();
      params.append('inicio', detalleCatProductos.inicio);
      params.append('fin', detalleCatProductos.fin);
      params.append('order', detalleCatProductos.order);
      params.append('marca', detalleCatProductos.marca);
      params.append('marcaFiltro', detalleCatProductos.marcaFiltro);
      params.append('atributo', detalleCatProductos.atributo);
      params.append('opciones', detalleCatProductos.opciones);
      params.append('modelo', detalleCatProductos.modelo);
      params.append('ano', detalleCatProductos.ano);
      params.append('ancho', detalleCatProductos.ancho);
      params.append('perfil', detalleCatProductos.perfil);
      params.append('aro', detalleCatProductos.aro);
      params.append('origen', detalleCatProductos.origen);

      return params;
  }
  public getProductosFiltrado(detalleCatProductos: DetalleCatProductos): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = this.getParametrosBusquedas(detalleCatProductos);
      params.append('accion','filtro');

      return this.http.get(this.url+ 'productos.php?' + params.toString() , options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }

   public getProductosHome(tipo): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('accion',tipo);

      return this.http.get(this.url+ 'productos.php?' + params.toString() , options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }

  public getDetalleProductosFiltrado(detalleCatProductos: DetalleCatProductos): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = this.getParametrosBusquedas(detalleCatProductos);
      params.append('accion','detallefiltro');

      return this.http.get(this.url+ 'productos.php?'+ params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }

  public getProductos(): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('accion','todos');

      return this.http.get(this.url+ 'productos.php?' + params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }
  public getProductosById(id: string): Promise<any>{
      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('id',id);
      params.append('accion','unico');
      return this.http.get(this.url+ 'productos.php?' + params.toString(), options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
  }
  public getDetalleProductos(): Promise<any>{

      let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();
      params.append('accion','detalle');

      return this.http.get(this.url+ 'productos.php?'+ params.toString(), options).toPromise()
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
