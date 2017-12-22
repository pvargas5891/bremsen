import { Component, OnInit } from '@angular/core';
import { InformacionService } from '../../services/informacion.service';
import { UserService } from "../../_services/user.service";
import { AuthenticationService } from '../../_services/index';
import { Cliente } from './cliente';
import { Router } from '@angular/router'
@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html'
})

export class RegistroComponent {

   cliente = new Cliente();
   estado:boolean = false;
   errorMessage: String;
   loading = false;
   loading2 = false;
   returnUrl: string;
   error = '';
   error2 = '';
   model: any = {};
   regionValido: boolean = true;
   ciudadValido: boolean = true;
   comunaValido: boolean = true;
  constructor(
    public _is: InformacionService,
    public users: UserService,
    private authenticationService: AuthenticationService,
    private route: Router
  ) {

    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
    if(currentUser != null){
      if(currentUser.token === 'active'){
             this.route.navigate(['/home']);
      }
    }
  }

   cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
  }
    cambiaComuna(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);
    }

    saveRegistro(): void {


      if(typeof this.cliente.region == 'undefined'){
        this.regionValido = false;
        return;
      }
      if(typeof this.cliente.ciudad == 'undefined'){
        this.ciudadValido = false;
        return;
      }
      if(typeof this.cliente.comuna == 'undefined'){
        this.comunaValido = false;
        return;
      }
      this.loading = true;
     this.users.create(this.cliente)
	     .then( data => {
           this.reset();
           if(data=='OK'){
              this.estado = true;
              this.loading = false;
           }
		    },
        error => this.errorMessage = <any> error );
   }

   private reset() {
     this.cliente.nombreCompleto = null;
	   this.cliente.region = null;
	   this.cliente.ciudad = null;
	   this.cliente.comuna = null;
	   this.cliente.direccion = null;
	   this.cliente.email = null;
	   this.cliente.genero = null;
	   this.cliente.telefono = null;
	   this.errorMessage = null;
	   this.estado = false;
   }

   login() {
        this.loading2 = true;
        this.authenticationService.login(this.model.username, this.model.password)
            .then(result => {
                //console.debug(result);
                if (result === true) {
                    // login successful
                    //this.router.navigate(['/']);
                  var currentUser = JSON.parse(localStorage.getItem('currentUser'));
                  //console.debug(currentUser);
                    //this.nombreCliente = currentUser.usuario.nombre;
                   //this.autenticado = true;
                    this.loading2 = false;
                    this.route.navigate(['/']);
                } else {
                    // login failed
                    this.error2 = 'Usuario y password son incorrectos';
                    this.loading2 = false;
                }
            });
    }

}
