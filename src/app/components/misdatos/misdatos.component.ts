import { Component, OnInit } from '@angular/core';
import { UserService } from '../../_services/user.service';
import { Cliente } from '../../components/registro/cliente';
import { InformacionService } from '../../services/informacion.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-misdatos',
  templateUrl: './misdatos.component.html',
    styleUrls: ['./misdatos.component.css']
})
export class MisdatosComponent implements OnInit {

  public cliente = new Cliente();
  public id: string;
  public actual: string="";
  public nueva1: string="";
  public nueva2: string="";
  public errorPass = false;
  public errorMsg: string = "";

  estado:boolean = false;
  estado2:boolean = false;
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
  public historialCompra: any[] = [];;
 constructor(private userService: UserService,
              private route: Router,
              public _is: InformacionService
                ) {

       var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){
                this.id = currentUser.usuario.id;
                this.getDatosPersonales();
              this.getHistorialCliente();
            }else{
                this.route.navigate(['/home']);
            }

          }else{
            this.route.navigate(['/home']);
          }
    }

  ngOnInit() {
  }
  getHistorialCliente = function () {

    this.userService.getHistorialById(this.id).then(
      data => {
        console.debug(data);
        this.historialCompra=data;
        
      }
    );

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
            this.cliente.password = data[0].password;
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

  public updateCliente = function (){

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

    this.userService.update(this.cliente).then(
          data => {

             if(data=='OK'){
              this.estado = true;
              this.loading = false;
           }

          }
        );
  }
  public updatePassword = function (){
    if(this.actual == 'undefined' || this.actual == ''){
      this.errorPass =true;
        this.errorMsg="Debe ingresar la password actual";
        return;
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
    if(this.actual != this.cliente.password){
      this.errorPass =true;
        this.errorMsg="La password actual no es válida!";
        return;
    }
    if(this.nueva1 != this.nueva2){
      this.errorPass =true;
      this.errorMsg="Las password no coinciden!";
      return;
    }
    this.errorPass =false;
    this.cliente.password=this.nueva2;
    this.userService.updatePassword(this.cliente).then(

        data => {
           if(data=='OK'){
              this.estado2 = true;
              this.loading2 = false;
           }
        }

    );
  }
public saveFactura = function () {
  this.userService.saveFactura(this.cliente).then(
    data => {

      //window.location.href = "http://bremsen.kodamas.cl/entrega/webpay/tbk-normal.php?usuario=" + this.id;

    },
    error => {
      console.debug(error);
    });
}
     
}
