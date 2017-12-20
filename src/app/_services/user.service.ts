import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Http, RequestOptions,Response, Headers  } from '@angular/http';
import { Cliente } from '../components/registro/cliente';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class UserService {

    url:string = 'http://bremsen.kodamas.cl/maqueta/';
    constructor(public http:Http) { }


    getById(id: string) {
        let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('id', id);

        let body = params.toString();
        return this.http.post(this.url+ 'getCliente.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
    }

    /*getHistorialById(id: string) {
        let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('id', id);

        let body = params.toString();
        return this.http.post(this.url+ 'getClienteHistorial.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
    }*/

    update(registro: Cliente) {

       let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('id', registro.id);
        params.append('nombreCompleto', registro.nombreCompleto);
        params.append('comuna', registro.comuna);
        params.append('ciudad', registro.ciudad);
        params.append('region', registro.region);
        params.append('direccion', registro.direccion);
        params.append('genero', registro.genero);
        params.append('telefono', registro.telefono);
        params.append('email', registro.email);
        let body = params.toString();
        return this.http.post(this.url+ 'updateCliente.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

    }

    public updatePassword(registro: Cliente): Promise<string>{

      let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('id', registro.id);
        params.append('password', registro.password);
        params.append('accion', 'password');

        let body = params.toString();
        return this.http.post(this.url+ 'updateCliente.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);
    }

    public create(registro: Cliente): Promise<string>{

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
        let body = params.toString();
        return this.http.post(this.url+ 'registro.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);


  }

  public loginUserService(registro: Cliente): Promise<string>{

    let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        let options = new RequestOptions({ headers: headers });
        const params = new URLSearchParams();
        params.append('usuario', registro.username);
        params.append('password', registro.password);

        let body = params.toString();
        let rs: string;
        return this.http.post(this.url+ 'valida.php', body, options).toPromise()
	           .then(this.extractData)
             .catch(this.handleErrorPromise);

  }

  private extractData(res: Response) {
        //console.debug(res);
        let body = res.json();
        return body;
    }

    private handleErrorPromise (error: Response | any) {
	    return Promise.reject(error.message || error);
    }
}
