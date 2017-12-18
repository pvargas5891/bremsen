import { Component, OnInit } from '@angular/core';
import { InformacionService } from '../../services/informacion.service';
import { UserService } from "../../_services/user.service";
import { Cliente } from './cliente';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html'
})

export class RegistroComponent {

   cliente = new Cliente();
   estado:boolean = false;
   errorMessage: String;
  constructor(
    public _is: InformacionService,
    public users: UserService
  ) {}

   cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
  }
    cambiaComuna(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);
    }

    saveRegistro(): void {
     this.users.create(this.cliente)
	     .then( data => {
           this.reset();
           if(data=='OK'){
              this.estado = true;
           }
			      console.debug(data);
		    },
        error => this.errorMessage = <any>error);
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

}
