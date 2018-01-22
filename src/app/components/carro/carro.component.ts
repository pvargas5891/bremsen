import { Component, OnInit,AfterViewInit } from '@angular/core';
import { CarroCompraService } from '../../services/carro-compra.service';
import { InformacionService } from '../../services/informacion.service';
import { Router } from '@angular/router';
import { ProductosService } from '../../services/productos.service';
import { Producto} from "../producto/producto";
import { DomSanitizer } from '@angular/platform-browser';

declare var jQuery:any;
declare var $:any;

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
  public costoFinalInstalacion=0;
  estado: boolean = false;
  public regionInstalacion: string;
  public ciudadInstalacion: string;
  public comunaInstalacion: string;
  public aceptaInstalacion1value: string;
  public nombresInstalacion1value: string;
  public direccionInstalacion1value: string;
  public aceptaInstalacion2value: string;
  public nombresInstalacion2value: string;
  public direccionInstalacion2value: string;
  public rutInstalacion2value:string;
  public aceptaInstalacion3value: string;
  public tallerAsociadovalue: string;
  public fechaInstalacionvalue: string;
  public bloqueHorariovalue: string;
  public direccionInstalacion4value: string;
  public aceptaInstalacion4value: string;
  public tipoInstalacion:number = 1;

  public costoNeumaticos:number = 0;
  //public costoInstalacion:number = 0;
  public descuentoAplicado:number = 0;
  public totalTotales:number = 0;
  public activaInstalacion: boolean = false;
  public activaErrorNoDisponible: boolean = false;
  
  errorMessage: string;





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

      localStorage.setItem('instalacionTemporal', null);

   }

  ngOnInit() {


  }


  tipoInstalacionBoton(tipo: number):void{
        //this.validaRegion();
        this.tipoInstalacion = tipo;
        console.debug(this.tipoInstalacion);
        if(tipo==3){
         
        }
        this.calculaTotales();
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



   public aceptaInstalacion1Valido: boolean = false;

  guardaInstalacion1= function(){
     this.tipoInstalacion = 1;
     if(!this.validaRegion())
        return;

     this.estado = true;
     this.errorMessage="";
     //this.calculaTotales();
     this.guardaTemportalData();

  }

public instalacionUno: boolean = false;
public instalacionDos: boolean = false;
public instalacionTres: boolean = false;
  public instalacionCuatro: boolean = false;
  public valorinstalacionUno: number = 0;
  public valorinstalacionDos: number = 0;
  public valorinstalacionTres: number = 0;
  public valorinstalacionCuatro: number=0;
 public seleccionaInstalacion = function(comuna){
   this._is.getInstalacionByComuna(comuna, this.id).then(data => {
          console.debug(data);
          this.instalacionUno = false;
          this.instalacionDos = false;
          this.instalacionTres = false;
          this.instalacionCuatro = false;
          this.valorinstalacionUno = 0;
          this.valorinstalacionDos = 0;
          this.valorinstalacionTres = 0;
          this.valorinstalacionCuatro = 0;
          if(data.length==0){
             this.activaInstalacion=true;
             this.activaErrorNoDisponible = true;
          }
          for(var i=0; i<data.length;i++){
              if(data[i].tipo=='1'){
                this.activaInstalacion=true;
                this.instalacionUno=true;
                this.valorinstalacionUno = data[i].valor;
              }
            if (data[i].tipo=='2'){
                this.activaInstalacion=true;
                this.instalacionDos=true;
              this.valorinstalacionDos = data[i].valor;
              }
            if (data[i].tipo=='3'){
                this.activaInstalacion=true;
                this.instalacionTres=true;
              this.valorinstalacionTres = data[i].valor;
              }
            if (data[i].tipo=='4'){
                this.activaInstalacion=true;
                this.instalacionCuatro=true;
              this.valorinstalacionCuatro = data[i].valor;
              }
          }
    });
 }

  public aceptaInstalacion2Valido: boolean = false;

  guardaInstalacion2= function(){
     this.tipoInstalacion = 2;
    if(!this.validaRegion())
        return;

    this.estado = true;
    this.errorMessage="";
     //this.calculaTotales();
     this.guardaTemportalData();
  }



  public aceptaInstalacion3Valido: boolean = false;
  public validaTalleres: boolean = false;
  guardaInstalacion3= function(){
     this.tipoInstalacion = 3;
    if(!this.validaRegion())
        return;
    console.debug(this.tallerAsociadovalue);
    if(typeof this.tallerAsociadovalue == 'undefined' || this.tallerAsociadovalue == ""){
        this.validaTalleres = true;
        return;
    }
    this.validaTalleres = false;
    this.estado = true;

    this.errorMessage="";
     //this.calculaTotales();
     this.guardaTemportalData();
  }



  public direccionInstalacion4Valido: boolean = false;
  public aceptaInstalacion4Valido: boolean = false;
  guardaInstalacion4= function(){
     this.tipoInstalacion = 4;
    if(!this.validaRegion())
        return;

    this.estado = true;
    this.errorMessage="";
    //
      this.guardaTemportalData();

  }



  public guardaTemportalData = function (){

    localStorage.setItem('instalacionTemporal', null);
    var instalacionTemporal = new Array();
     var datos = {
        regionInstalacion: this.regionInstalacion,
        ciudadInstalacion: this.ciudadInstalacion,
        comunaInstalacion: this.comunaInstalacion,
        aceptaInstalacion1value: this.aceptaInstalacion1value,
        nombresInstalacion1value: this.nombresInstalacion1value,
        direccionInstalacion1value: this.direccionInstalacion1value,
        aceptaInstalacion2value: this.aceptaInstalacion2value,
        nombresInstalacion2value: this.nombresInstalacion2value,
        direccionInstalacion2value: this.direccionInstalacion2value,
        rutInstalacion2value: this.rutInstalacion2value,
        aceptaInstalacion3value: this.aceptaInstalacion3value,
        tallerAsociadovalue: this.tallerAsociadovalue,
        fechaInstalacionvalue: this.fechaInstalacionvalue,
        bloqueHorariovalue: this.bloqueHorariovalue,
        direccionInstalacion4value: this.direccionInstalacion4value,
        aceptaInstalacion4value: this.aceptaInstalacion4value,
        tipoInstalacion: this.tipoInstalacion,
        costoNeumaticos: this.costoNeumaticos,
        costoInstalacion:this.costoFinalInstalacion,
        descuentoAplicado:this.descuentoAplicado,
        totalTotales:this.totalTotales
      };
        instalacionTemporal.push(datos);


      localStorage.setItem('instalacionTemporal', JSON.stringify(instalacionTemporal));
  }
  cambiaCiudad(selectedRegion: string): void{
      this._is.getCiudades(selectedRegion);
      this._is.getTalleresByRegion(selectedRegion);
  }
  cambiaComuna(selectedCiudad: string): void{
    this._is.getComunas(selectedCiudad);
  }
  private getCarroAll = function (){

    this.carro.getCarroAll(this.id).then(

      data => {
        this.carroCompra =  [];
        this.costoNeumaticos = 0;

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
            //this.costoInstalacion += parseInt(producto.VALOR_INSTALACION) * carro.cantidad;
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
            this.costoNeumaticos+=producto.totalParcial;
            this.calculaTotales();
		    },
        error => this.errorMessage = <any>error);

        return producto;

}
public cambiaCantidad(id,cantidad){
  //actualizaCarro
 // console.debug(id);
 //console.debug(cantidad);
var currentUser = JSON.parse(localStorage.getItem('currentUser'));
  if (currentUser != null) {
    if (currentUser.token === 'active') {
  this.carro.actualizaCarro(id,cantidad).then(

    data =>{
          this.carroCompra =  [];
          this.costoNeumaticos = 0;

          for(var id in data){
               this.carroCompra.push(this.getProductoById(data[id]));
          }
          this.seleccionaInstalacion(this.comunaInstalacion);
          localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
          this.calculaTotales();
    },
    error=>{

    }

  );
  }
  }else{
    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    //console.debug(carroTemporal);
    if (carroTemporal != null) {
      this.carroCompra =  [];
      this.costoNeumaticos = 0;

      for (var i = 0; i < carroTemporal.length; i++) {
        if (carroTemporal[i].id_producto==id){
            carroTemporal[i].cantidad=cantidad;
        }
        this.carroCompra.push(this.getProductoById(carroTemporal[i]));
      }
      this.seleccionaInstalacion(this.comunaInstalacion);
      localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
      this.calculaTotales();
    }
  }

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
          this.seleccionaInstalacion(this.comunaInstalacion);
          localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
          this.calculaTotales();
        },
        error => {

        }

      );
    } else {
      this.route.navigate(['/home']);
    }
  }else{
    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));

    if (carroTemporal != null) {
      this.carroCompra =  [];
      this.costoNeumaticos = 0;

      for (var i = 0; i < carroTemporal.length; i++) {
        if (carroTemporal[i].id_producto!=id)
          this.carroCompra.push(this.getProductoById(carroTemporal[i]));
      }
      this.seleccionaInstalacion(this.comunaInstalacion);
      localStorage.setItem('cambiaCarro', JSON.stringify({ estado: 'actualize' }));
      this.calculaTotales();
    }
  }

}

  private getCarroAllSinSesion = function () {
    this.carroCompra = [];
    this.cantidadProductos = 0;
    this.costoNeumaticos = 0;

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

  if(!this.estado){
    return;
  }


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

public calculaTotales = function (){

  if(this.tipoInstalacion == 1){
     this.costoFinalInstalacion = parseInt(this.valorinstalacionUno);
  }
  if(this.tipoInstalacion == 2){
    this.costoFinalInstalacion = parseInt(this.valorinstalacionDos);
  }
    if(this.tipoInstalacion == 3){
      this.costoFinalInstalacion = parseInt(this.valorinstalacionTres);
  }
    if(this.tipoInstalacion == 4){
      this.costoFinalInstalacion = parseInt(this.valorinstalacionCuatro);
  }
  this.totalTotales = this.costoNeumaticos + this.costoFinalInstalacion;
  this.totalTotales -= this.descuentoAplicado;
//public descuentoAplicado:number = 0;
//public totalTotales:number = 0;
}
public voucher: string = "";
public aplicaDescuento = function(){
    // servicio que trae el descuento
    this.descuentoAplicado = 10000;

}
  }

