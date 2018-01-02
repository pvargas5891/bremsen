import { Component,Input, OnInit, DoCheck } from '@angular/core';
import { AuthenticationService } from '../../_services/index';
import { CarroCompraService } from '../../services/carro-compra.service';
import { Router } from '@angular/router';
import { ProductosService } from '../../services/productos.service';
import { Producto} from "../producto/producto";
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html'
})
export class HeaderComponent implements DoCheck{
    model: any = {};
    loading = false;
    returnUrl: string;
    error = '';
    autenticado = false;
    nombreCliente = "";
    id = "";
    cantidadProductos = 0;
    totalCarro = 0;
    logueado = false;
    searchValue: string;
    public carroCompra:any[] =  [];

    @Input() carroChange: string;
     constructor(
        private authenticationService: AuthenticationService,
        private route: Router,
        private carro: CarroCompraService,
        private _productoService: ProductosService,
        private sanitizer: DomSanitizer
      ) {

          var currentUser = JSON.parse(localStorage.getItem('currentUser'));

          if(currentUser != null){
             //console.debug(currentUser);
            if(currentUser.token === 'active'){
                this.nombreCliente = currentUser.usuario.nombre;
                this.autenticado = true;
                this.logueado = true;
                this.id = currentUser.usuario.id;
                this.getCarroAll();
            }
          }
           localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'muerto' }));
           localStorage.setItem('carroUserTemporal', null);
         }
      public ngDoCheck(){

        var currentUser = JSON.parse(localStorage.getItem('currentUser'));
        if(currentUser != null){
             //console.debug(currentUser);
            if(currentUser.token === 'active'){

              var cambiaCarro = JSON.parse(localStorage.getItem('cambiaCarro'));
              //console.debug(cambiaCarro.estado);
              if(cambiaCarro.estado=='actualize'){
                this.id = currentUser.usuario.id;
                this.getCarroAll();
               // console.debug("cambio carro");
                localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'muerto' }));
              }
            }
        }else{
          var cambiaCarro = JSON.parse(localStorage.getItem('cambiaCarro'));
          //console.debug(cambiaCarro.estado);
          if (cambiaCarro.estado == 'actualize') {
            this.getCarroAllSinSesion();
            // console.debug("cambio carro");
            localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'muerto' }));
          }
        
        }
      }
      public inSearch = function(){
        if(typeof this.searchValue === 'undefined' || this.searchValue == ''){
          return;
        }
        //console.debug(this.searchValue);
        this.route.navigate(['/search/'+'menu/'+this.searchValue]);
      }
      public login() {
        this.loading = true;
        this.authenticationService.login(this.model.username, this.model.password)
            .then(result => {
                console.debug(result);
                if (result === true) {
                    // login successful
                    //this.router.navigate(['/']);
                  var currentUser = JSON.parse(localStorage.getItem('currentUser'));
                  //console.debug(currentUser);

                    this.nombreCliente = currentUser.usuario.nombre;
                    this.autenticado = true;
                    this.loading = false;
                    this.agregaCarrosinSesion(currentUser.usuario.id);
                    this.id = currentUser.usuario.id;
                    this.getCarroAll();
                    
                } else {
                    // login failed
                    this.error = 'Usuario y password son incorrectos';
                    this.loading = false;
                }
            });
      }
     public logout(): void {
            // clear token remove user from local storage to log user out
          //this.token = null;
          localStorage.removeItem('currentUser');
         this.autenticado = false;
         this.route.navigate(['/home']);
        }

    private getCarroAll = function (){
           this.carroCompra = [];
           this.cantidadProductos = 0;
           this.totalCarro = 0;

         
          this.carro.getCarroAll(this.id).then(

            data => {
             // console.debug(data);
                for(var id in data){
                     this.carroCompra.push(this.getProductoById(data[id]));
                }
                //console.debug(this.carroCompra);
            },


          );
           

    }
  private getCarroAllSinSesion = function () {
    this.carroCompra = [];
    this.cantidadProductos = 0;
    this.totalCarro = 0;


      var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
      //console.debug(carroTemporal);
      if (carroTemporal != null) {
        for (var i = 0; i < carroTemporal.length; i++) {
          this.carroCompra.push(this.getProductoById(carroTemporal[i]));
        }

      }


  }

  private agregaCarrosinSesion(usuario){


    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    //console.debug(carroTemporal);
    if (carroTemporal != null) {
      for (var i = 0; i < carroTemporal.length; i++) {
        this.carro.agregarCarro(carroTemporal[i].cantidad, carroTemporal[i].id_producto, usuario)
          .then(
          data => {
          },
          error => {

          }
          );
      }

    }



    
  }

  public getProductoById = function (carro): Producto{
    var producto = new Producto();
    this._productoService.getProductosById(carro.id_producto)
	     .then( data => {
           // console.debug(data);

            producto.ID = data[0].ID;
            producto.CODIGO = data[0].CODIGO;
            producto.MARCA = data[0].MARCA;
            producto.MODELO = data[0].MODELO;
            producto.MEDIDA = data[0].MEDIDA;
            producto.CATEGORIA = data[0].CATEGORIA;
            producto.ANCHO = data[0].ANCHO;
            producto.PERFIL = data[0].PERFIL;
            producto.ARO = data[0].ARO;
            producto.CARGA = data[0].CARGA;
            producto.LARGO = data[0].LARGO;
            producto.ALTO = data[0].ALTO;
            producto.PESO = data[0].PESO;
            producto.NETO = data[0].NETO;
            producto.UNITARIO = data[0].UNITARIO;
            producto.VALOR_INSTALACION = data[0].VALOR_INSTALACION;
            producto.TOTAL = data[0].TOTAL;
            producto.MC = data[0].MC;
            producto.NETO2 = data[0].NETO2;
            producto.PRECIO_FINAL = data[0].PRECIO_FINAL;
            producto.PRECIO_OFERTA = data[0].PRECIO_OFERTA;
            producto.JPG = data[0].JPG;
            producto.TITULO = data[0].TITULO;
            producto.ATRIBUTOS = data[0].ATRIBUTOS;
            producto.DESCRIPCION = data[0].DESCRIPCION;
            producto.LOGO = data[0].LOGO;
            producto.INCLUYE_INSTALACION = data[0].INCLUYE_INSTALACION;
            producto.DESPACHO = data[0].DESPACHO;
            producto.ULTIMOS_DIAS = data[0].ULTIMOS_DIAS;
            producto.RUNFLAT = data[0].RUNFLAT;
            producto.OFERTA = data[0].OFERTA;
            producto.ALTO_DESEMPENO = data[0].ALTO_DESEMPENO;
            //producto.VIDEO = this.sanitizaUrlExtern(data[0].VIDEO);
            producto.STOCK = data[0].STOCK;
            producto.cantidadCarro=carro.cantidad;
            producto.idCarro=carro.id_carro;
            producto.idPago=carro.pagosID;
            producto.TBK_MONTO=carro.TBK_MONTO;
            producto.totalParcial = parseInt(carro.cantidad)*parseInt(producto.PRECIO_FINAL);
            this.cantidadProductos += parseInt(carro.cantidad);
            this.totalCarro += producto.totalParcial;
		    },
        error => this.errorMessage = <any>error);

        return producto;

}

}
