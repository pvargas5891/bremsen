import { Component, OnInit } from '@angular/core';
import { CarroCompraService } from '../../services/carro-compra.service';
import { InformacionService } from '../../services/informacion.service';
import { UserService } from '../../_services/user.service';
import { Router } from '@angular/router';
import { AuthenticationService } from '../../_services/index';
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

      public username="";
      public password="";

      public error = '';
      public loading = false;
      public estado:boolean = false;
      public errorMessage: String;

      public nueva1: string="";
      public nueva2: string="";
  public desactivaBotones = true;
        public errorPass = false;
  public errorMsg: string = "";

       public costoNeumaticos:number = 0;
  public costoInstalacion:number = 0;
  public descuentoAplicado:number = 0;
  public totalTotales:number = 0;
  public datosCarro;
  public codigoCompra = 0;
  public tipoLoginCompra = 0;
  constructor(
      private carro: CarroCompraService,
      private route: Router,
      private authenticationService: AuthenticationService,
      private _productoService: ProductosService,
      private userService: UserService,
      private sanitizer: DomSanitizer,
      public _is: InformacionService,

  ) {


 var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){

                this.route.navigate(['/checkin']);
            }

          }
    this.tipoLoginCompra = JSON.parse(localStorage.getItem('tipoLoginCompra'));
    console.debug(this.tipoLoginCompra);      
    if (typeof this.tipoLoginCompra === 'undefined' || this.tipoLoginCompra == null || this.tipoLoginCompra == 0){
      localStorage.setItem('tipoLoginCompra', JSON.stringify({ estado: 2 }));
      this.tipoLoginCompra = JSON.parse(localStorage.getItem('tipoLoginCompra'));
    }

    this.datosCarro = JSON.parse(localStorage.getItem('instalacionTemporal'));
          //console.debug(datosCarro);
          this.costoNeumaticos=this.datosCarro[0].costoNeumaticos;
          this.costoInstalacion=this.datosCarro[0].costoInstalacion;
          this.descuentoAplicado=this.datosCarro[0].descuentoAplicado;
          this.totalTotales=this.datosCarro[0].totalTotales;

    /*this.carro.setDetallesCarro(this.datosCarro[0], this.id).then(
      data => {
        console.debug(data);
        this.codigoCompra = data[0].pagosID;
      },
      error => {
        console.debug(error);
      });*/
    window.scrollTo(0, 0);
   }

     cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);

  }
    cambiaComuna(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);

    }


cambiaCiudadEmpresa(selectedRegion: string): void{
      this._is.getCiudadesEmpresa(selectedRegion);

  }
    cambiaComunaEmpresa(selectedCiudad: string): void{
      this._is.getComunasEmpresa(selectedCiudad);

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




           this.userService.createWithFactura(this.cliente)
	     .then( data => {
             this.errorMessage = "";
           if(data=='OK'){
              this.estado = true;
              this.loading = false;

            this.authenticationService.login(this.cliente.email, this.cliente.password)
            .then(result => {

                if (result === true) {
                   var currentUser = JSON.parse(localStorage.getItem('currentUser'));
                   this.agregaCarrosinSesion(currentUser.usuario.id);


                }
            });

           }
           if(data=='EXISTE'){
             this.errorMessage = "El email ingresado ya existe";
              this.loading = false;
           }
		    },
        error => this.errorMessage = <any> error );

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
     this.userService.createSinSesion(this.cliente)
	     .then( data => {
             this.errorMessage = "";
           if(data=='OK'){
              this.estado = true;
              this.loading = false;

            this.authenticationService.login(this.cliente.email, this.cliente.password)
            .then(result => {

                if (result === true) {
                   var currentUser = JSON.parse(localStorage.getItem('currentUser'));
                   this.agregaCarrosinSesion(currentUser.usuario.id);
                }
            });

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
  public activaTransferencia = false;
  private agregaCarrosinSesion(usuario) {


    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    //console.debug(carroTemporal);
    if (carroTemporal != null) {
      for (var i = 0; i < carroTemporal.length; i++) {
        this.carro.agregarCarro(carroTemporal[i].cantidad, carroTemporal[i].id_producto, usuario)
          .then();
      }
      this.carro.setDetallesCarro(this.datosCarro[0], usuario).then(
        data => {
          console.debug(data);
          this.codigoCompra = data[0].pagosID;
          this.desactivaBotones = false;
          var claveFunction = JSON.parse(localStorage.getItem('claveFunction'));
          if(claveFunction.estado==1)
            window.location.href = "http://www.bremsen.cl/webpay/tbk-normal.php?usuario=" + usuario;
          else
            this.activaTransferencia = true;
        },
        error => {
          console.debug(error);
        });
          
        
        
      //});
    }




  }
  public insertaClave = function(dato){
    localStorage.setItem('claveFunction', JSON.stringify({ estado: dato }));
  }
  public realizaTransferencia = function () {
    window.location.href = "http://www.bremsen.cl/webpay/tbk-normal.php?transferencia=true&usuario=" + this.id;
  }
  public loading2=false;
  public error2="";
  login() {
            this.loading2 = true;
            this.authenticationService.login(this.username, this.password)
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
          this.route.navigate(['/checkin']);
                        } else {
                              // login failed
                              this.error2 = 'Usuario y password son incorrectos';
                              this.loading2 = false;
                        }
                  });
      }
}
