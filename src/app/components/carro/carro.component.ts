import { Component, OnInit } from '@angular/core';
import { CarroCompraService } from '../../services/carro-compra.service';
import { InformacionService } from '../../services/informacion.service';
import { Router } from '@angular/router';
import { ProductosService } from '../../services/productos.service';
import { Producto} from "../producto/producto";
import { DomSanitizer } from '@angular/platform-browser';
@Component({
  selector: 'app-carro',
  templateUrl: './carro.component.html',
  styles: []
})
export class CarroComponent implements OnInit {

  public carroCompra:any[] =  [];
  public id;
  public incluyeInstalacion = false;
  regionValido: boolean = true;
  ciudadValido: boolean = true;
  comunaValido: boolean = true;

  estado: boolean = false;
  regionInstalacion: string;
  ciudadInstalacion: string;
  comunaInstalacion: string;
  errorMessage: string;
  tipoInstalacion:number = 1;
  constructor(private carro: CarroCompraService,
              private route: Router,
              private _productoService: ProductosService,
              private sanitizer: DomSanitizer,
              public _is: InformacionService
            ) {

      var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){
                this.id = currentUser.usuario.id;
                this.getCarroAll();
            }else{
                this.route.navigate(['/home']);
            }

          }else{
            //this.route.navigate(['/home']);
            this.getCarroAllSinSesion();
          }

   }

  ngOnInit() {
  }
  

  tipoInstalacionBoton(tipo: number):void{
        this.validaRegion();

  }

 validaRegion = function(){
   console.debug(this.regionInstalacion);
    if(typeof this.regionInstalacion == 'undefined'){
        this.regionValido = false;
        this.errorMessage="Falta que seleccione la región de instalación";
        return false;
      }
      if(typeof this.ciudadInstalacion == 'undefined'){
        this.regionValido = true;
        this.ciudadValido = false;
        this.errorMessage="Falta que seleccione la ciudad de instalación";
        return false;
      }
      if(typeof this.comunaInstalacion == 'undefined'){
        this.regionValido = true;
        this.ciudadValido = true;
        this.comunaValido = false;
        this.errorMessage="Falta que seleccione la comuna de instalación";
        return false;
      }
        this.regionValido = true;
        this.ciudadValido = true;
        this.comunaValido = true;
      return true;
 }

  public aceptaInstalacion1value: string;
  public nombresInstalacion1value: string;
  public direccionInstalacion1value: string;

   public aceptaInstalacion1Valido: boolean = false;

  guardaInstalacion1= function(){
     this.tipoInstalacion = 1;
     if(!this.validaRegion())
        return;

     this.estado = true;
     this.errorMessage="";
  }

  public aceptaInstalacion2value: string;
  public nombresInstalacion2value: string;
  public direccionInstalacion2value: string;
  public rutInstalacion2value:string;

  public aceptaInstalacion2Valido: boolean = false;

  guardaInstalacion2= function(){
     this.tipoInstalacion = 2;
    if(!this.validaRegion())
        return;

    this.estado = true;
    this.errorMessage="";
  }

  public aceptaInstalacion3value: string;
  public tallerAsociadovalue: string;
  public fechaInstalacionvalue: string;
  public bloqueHorariovalue: string;

  public aceptaInstalacion3Valido: boolean = false;

  guardaInstalacion3= function(){
     this.tipoInstalacion = 3;
    if(!this.validaRegion())
        return;

    this.estado = true;
    this.errorMessage="";
  }

  public direccionInstalacion4value: string;
  public aceptaInstalacion4value: string;

  public direccionInstalacion4Valido: boolean = false;
  public aceptaInstalacion4Valido: boolean = false;
  guardaInstalacion4= function(){
     this.tipoInstalacion = 4;
    if(!this.validaRegion())
        return;

    this.estado = true;
    this.errorMessage="";
  }
  cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
  }
  cambiaComuna(selectedCiudad: string): void{
    this._is.getComunas(selectedCiudad);
  }
  private getCarroAll = function (){

    this.carro.getCarroAll(this.id).then(

      data => {
        this.carroCompra =  [];
       // console.debug(data);
          for(var id in data){
               this.carroCompra.push(this.getProductoById(data[id]));
          }
        if (this.carroCompra.length==0){
          this.route.navigate(['/home']);
        }
          //console.debug(this.carroCompra);
      },


    );

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

            if(producto.INCLUYE_INSTALACION == 'Si' || producto.DESPACHO == 'Si')
              this.incluyeInstalacion=true;

            producto.DESPACHO = data[0].DESPACHO;
            producto.ULTIMOS_DIAS = data[0].ULTIMOS_DIAS;
            producto.RUNFLAT = data[0].RUNFLAT;
            producto.OFERTA = data[0].OFERTA;
            producto.ALTO_DESEMPENO = data[0].ALTO_DESEMPENO;
            producto.VIDEO = this.sanitizaUrlExtern(data[0].VIDEO);
            producto.STOCK = data[0].STOCK;
            producto.cantidadCarro=carro.cantidad;
            producto.idCarro=carro.id_carro;
            producto.idPago=carro.pagosID;
            producto.TBK_MONTO=carro.TBK_MONTO;
            producto.totalParcial = parseInt(carro.cantidad)*parseInt(producto.PRECIO_FINAL);
		    },
        error => this.errorMessage = <any>error);

        return producto;

}
public cambiaCantidad(id,cantidad){
  //actualizaCarro
 // console.debug(id);
 //console.debug(cantidad);
  this.carro.actualizaCarro(id,cantidad).then(

    data =>{
          this.carroCompra =  [];
          for(var id in data){
               this.carroCompra.push(this.getProductoById(data[id]));
          }
    },
    error=>{

    }

  );
}
public eliminaProductoCarro(id){
  //actualizaCarro
  if(!confirm("Se eliminará el producto seleccionado, desea seguir?")){
    return;
  }
  var currentUser = JSON.parse(localStorage.getItem('currentUser'));
  if (currentUser != null) {
    if (currentUser.token === 'active') {
      this.carro.eliminaCarro(id).then(
        data => {
          this.id = currentUser.usuario.id;
          this.getCarroAll();
        },
        error => {

        }

      );
    } else {
      this.route.navigate(['/home']);
    }
  }else{
    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    //console.debug(carroTemporal);
    if (carroTemporal != null) {
      for (var i = 0; i < carroTemporal.length; i++) {
        if (carroTemporal[i].id_producto!=id)
          this.carroCompra.push(this.getProductoById(carroTemporal[i]));
      }

    }
  }  
  
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

    } else {
      this.route.navigate(['/home']);
    }


  }

public sanitizaUrlExtern(url){
  return this.sanitizer.bypassSecurityTrustResourceUrl(url);
}

public checking = function(){
  var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){
                this.route.navigate(['/checkin']);
            }else{
                this.route.navigate(['/checkout']);
            }

          }else{
            this.route.navigate(['/checkout']);
          }
}
  }

