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
  selector: 'app-checkout-in',
  templateUrl: './checkout-in.component.html',
  styles: []
})
export class CheckoutInComponent {
 public cliente = new Cliente();
  public id: string;
  public isFactura: boolean=false;
    regionValido: boolean = true;
   ciudadValido: boolean = true;
   comunaValido: boolean = true;
error = '';
   loading = false;

     public costoNeumaticos:number = 0;
  public costoInstalacion:number = 0;
  public descuentoAplicado:number = 0;
  public totalTotales:number = 0;
  public datosCarro;
  public codigoCompra=0;
  constructor(

      private carro: CarroCompraService,
      private route: Router,
      private _productoService: ProductosService,
      private userService: UserService,
      private sanitizer: DomSanitizer,
      public _is: InformacionService

  ) {


     var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token != 'active'){
                this.route.navigate(['/checkout']);
            }
          }else{
            this.route.navigate(['/checkout']);
          }

          this.id = currentUser.usuario.id;
          this.getDatosPersonales();
          this.datosCarro = JSON.parse(localStorage.getItem('instalacionTemporal'));
          console.debug(this.datosCarro);
          this.costoNeumaticos=this.datosCarro[0].costoNeumaticos;
          this.costoInstalacion=this.datosCarro[0].costoInstalacion;
          this.descuentoAplicado=this.datosCarro[0].descuentoAplicado;
          this.totalTotales=this.datosCarro[0].totalTotales;

          this.carro.setDetallesCarro(this.datosCarro[0],this.id).then(
          data => {
            console.debug(data);
            this.codigoCompra = data[0].pagosID;
          },
          error => {
              console.debug(error);
          })
          ;
    window.scrollTo(0, 0);
  }

     cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
  }
    cambiaComuna(selectedCiudad: string): void{
      this._is.getComunas(selectedCiudad);
    }


private getDatosPersonales = function (){

        this.userService.getById(this.id).then(
          data => {

              this.cliente.id=data[0].id;
              this.cliente.nombreCompleto=data[0].nombre;
              this.cliente.comuna=data[0].comuna;
              this.cliente.ciudad=data[0].ciudad;
              this.cliente.region=data[0].region;
              this.cliente.direccion=data[0].direccion;
              this.cliente.genero=data[0].genero;
              this.cliente.telefono=data[0].telefono;
              this.cliente.email=data[0].email;
              this.cliente.username=data[0].username;
              this.cliente.password=data[0].password;
            this.cliente.razon = data[0].razon;
            this.cliente.rutempresa = data[0].rutempresa;
            this.cliente.giro = data[0].giro;
            this.cliente.telefonoempresa = data[0].telefonoempresa;
            this.cliente.direccionempresa = data[0].direccionempresa;
            this.cliente.regionempresa = data[0].regionempresa;
            this.cliente.ciudadempresa = data[0].ciudadempresa;
            this.cliente.comunaempresa = data[0].comunaempresa;
              this._is.getCiudades(this.cliente.region);
              this._is.getComunas(this.cliente.ciudad);

          }
        );

  }
  public esFactura = function(data){

        if(data==2){
          this.isFactura=true;
        }else{
          this.isFactura=false;
        }
  }
      public saveCheckin = function(){
        console.debug("pago factura");

         if(typeof this.cliente.regionempresa == 'undefined'){
        this.regionValido = false;
        return;
      }else{
        this.regionValido = true;
      }
      if(typeof this.cliente.ciudadempresa == 'undefined'){
        this.ciudadValido = false;
        return;
      }else{
        this.ciudadValido = true;
      }
      if(typeof this.cliente.comunaempresa == 'undefined'){
        this.comunaValido = false;
        return;
      }else{
        this.comunaValido = true;
      }
      this.loading=true;
      this.userService.saveFactura(this.cliente).then(
        data => {

             window.location.href="http://bremsen.kodamas.cl/entrega/webpay/tbk-normal.php?usuario="+this.id;

        },
      error => {
        console.debug(error);
      });
      }
    public pagarBoleta = function (){
          console.debug("pago boleta");
          this.loading=true;

          //guardar todo y redirect a webpay

          window.location.href="http://bremsen.kodamas.cl/entrega/webpay/tbk-normal.php?usuario="+this.id;
    }

  public realizaTransferencia = function(){
    window.location.href = "http://bremsen.kodamas.cl/entrega/webpay/tbk-normal.php?transferencia=true&usuario=" + this.id;
  }

}
