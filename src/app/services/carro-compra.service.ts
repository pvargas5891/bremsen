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
  public setDetallesCarro= function(carro,usuario):Promise<any>{

    let headers = new Headers({ 'Content-Type': 'application/json' });
      let options = new RequestOptions({ headers: headers });
      const params = new URLSearchParams();

      params.append('regionInstalacion',carro.regionInstalacion);
      params.append('ciudadInstalacion',carro.ciudadInstalacion);
      params.append('comunaInstalacion',carro.comunaInstalacion);
      params.append('aceptaInstalacion1value',carro.aceptaInstalacion1value);
      params.append('nombresInstalacion1value',carro.nombresInstalacion1value);
      params.append('direccionInstalacion1value',carro.direccionInstalacion1value);
      params.append('aceptaInstalacion2value',carro.aceptaInstalacion2value);
      params.append('nombresInstalacion2value',carro.nombresInstalacion2value);
      params.append('direccionInstalacion2value',carro.direccionInstalacion2value);
      params.append('rutInstalacion2value',carro.rutInstalacion2value);
      params.append('aceptaInstalacion3value',carro.aceptaInstalacion3value);
      params.append('tallerAsociadovalue',carro.tallerAsociadovalue);
      params.append('fechaInstalacionvalue',carro.fechaInstalacionvalue);
      params.append('bloqueHorariovalue',carro.bloqueHorariovalue);
      params.append('direccionInstalacion4value',carro.direccionInstalacion4value);
      params.append('aceptaInstalacion4value',carro.aceptaInstalacion4value);
      params.append('tipoInstalacion',carro.tipoInstalacion);
      params.append('costoNeumaticos',carro.costoNeumaticos);
      params.append('costoInstalacion',carro.costoInstalacion);
      params.append('descuentoAplicado',carro.descuentoAplicado);
      params.append('totalTotales',carro.totalTotales);
      params.append('usuario',usuario);
      params.append('accion','actualizadetalles');


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
