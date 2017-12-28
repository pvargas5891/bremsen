import { Component, OnInit } from '@angular/core';
import { CarroCompraService } from '../../services/carro-compra.service';
import { InformacionService } from '../../services/informacion.service';
import { UserService } from '../../_services/user.service';
import { Router } from '@angular/router';
import { ProductosService } from '../../services/productos.service';
import { Producto} from "../producto/producto";
import { DomSanitizer } from '@angular/platform-browser';
import { Cliente } from '../../components/registro/cliente';
@Component({
  selector: 'app-checkout-out',
  templateUrl: './checkout-out.component.html',
  styles: []
})
export class CheckoutOutComponent {
      public cliente = new Cliente();
      public id: string;
      public isFactura: boolean=false;
      public regionValido: boolean = true;
      public ciudadValido: boolean = true;
      public comunaValido: boolean = true;
      public regionValidoEmpresa: boolean = true;
      public ciudadValidoEmpresa: boolean = true;
      public comunaValidoEmpresa: boolean = true;

      public regionesPersona: any[] = [];
      public ciudadesPersona: any[] = [];
      public comunasPersona:any[] = [];

      public regionesEmpresa: any[] = [];
      public ciudadesEmpresa: any[] = [];
      public comunasEmpresa:any[] = [];
      public error = '';
      public loading = false;
      public estado:boolean = false;
      public errorMessage: String;

      public nueva1: string="";
      public nueva2: string="";
        public errorPass = false;
  public errorMsg: string = "";
  constructor(
      private carro: CarroCompraService,
      private route: Router,
      private _productoService: ProductosService,
      private userService: UserService,
      private sanitizer: DomSanitizer,
      public _is: InformacionService,

  ) {

console.debug(this._is.regiones);
this.regionesEmpresa=this._is.regiones;
this.ciudadesEmpresa=this._is.ciudades;
this.comunasEmpresa=this._is.comunas;

this.regionesPersona=this._is.regiones;
this.ciudadesPersona=this._is.ciudades;
this.comunasPersona=this._is.comunas;

 var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){

                this.route.navigate(['/checkin']);
            }

          }


   }

     cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
      this.ciudadesPersona=this._is.ciudades;
  }
    cambiaComuna(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);
      this.comunasPersona=this._is.comunas;
    }


cambiaCiudadEmpresa(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
      this.ciudadesEmpresa=this._is.ciudades;
  }
    cambiaComunaEmpresa(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);
      this.comunasEmpresa=this._is.comunas;
    }
  public esFactura = function(data){

        if(data==2){
          this.isFactura=true;
        }else{
          this.isFactura=false;
        }
  }
      public razonValido: boolean = true;
      public rutempresaValido: boolean = true;
      public giroValido: boolean = true;
      public telefonoempresaValido: boolean = true;
      public direccionempresaValido: boolean = true;

      public saveCheckin = function(){
        console.debug("pago factura");

         if(typeof this.cliente.regionempresa == 'undefined'){
            this.regionValidoEmpresa = false;
            return false;
          }else{
            this.regionValidoEmpresa = false;
          }
          if(typeof this.cliente.ciudadempresa == 'undefined'){
            this.ciudadValidoEmpresa = false;
            return false;
          }else{
            this.ciudadValidoEmpresa = false;
          }
          if(typeof this.cliente.comunaempresa == 'undefined'){
            this.comunaValidoEmpresa = false;
            return false;
          }else{
            this.comunaValidoEmpresa = false;
          }

          if(typeof this.cliente.razon == 'undefined'){
            this.razonValido = false;
            return false;
          }else{
            this.razonValido = false;
          }

          if(typeof this.cliente.rutempresa == 'undefined'){
            this.rutempresaValido = false;
            return false;
          }else{
            this.rutempresaValido = false;
          }

          if(typeof this.cliente.giro == 'undefined'){
            this.giroValido = false;
            return false;
          }else{
            this.giroValido = false;
          }

          if(typeof this.cliente.telefonoempresa == 'undefined'){
            this.telefonoempresaValido = false;
            return false;
          }else{
            this.telefonoempresaValido = false;
          }

          if(typeof this.cliente.direccionempresa == 'undefined'){
            this.direccionempresaValido = false;
            return false;
          }else{
            this.direccionempresaValido = false;
          }




      return true;


      }


      public saveRegistro(): void {


      if(typeof this.cliente.region == 'undefined'){
        this.regionValido = false;
        return;
      }else{
         this.regionValido = true;
      }
      if(typeof this.cliente.ciudad == 'undefined'){
        this.ciudadValido = false;
        return;
      }else{
        this.ciudadValido = true;
      }
      if(typeof this.cliente.comuna == 'undefined'){
        this.comunaValido = false;
        return;
      }else{
        this.comunaValido = true;
      }

      if(this.nueva1 == 'undefined' || this.nueva1 == ''){
       this.errorPass =true;
        this.errorMsg="Debe ingresar la nueva password";
        return;
    }
      if(this.nueva2 == 'undefined' || this.nueva2 == ''){
        this.errorPass =true;
        this.errorMsg="Debe ingresar repetir la password anterior";
        return;
    }

    if(this.nueva1 != this.nueva2){
      this.errorPass =true;
      this.errorMsg="Las password no coinciden!";
      return;
    }
    this.errorPass =false;
    this.cliente.password=this.nueva2;

      this.loading = true;

      if(this.cliente.facturacion=="2"){
         if(this.saveCheckin()){
              return;
         }
      }
     this.userService.create(this.cliente)
	     .then( data => {
             this.errorMessage = "";
           if(data=='OK'){
              this.estado = true;
              this.loading = false;
           }
           if(data=='EXISTE'){
             this.errorMessage = "El email ingresado ya existe";
              this.loading = false;
           }
		    },
        error => this.errorMessage = <any> error );
   }

    public pagarBoleta = function (){
          console.debug("pago boleta");
          this.loading=true;
    }
}
