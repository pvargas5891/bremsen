import { Component, OnInit,AfterViewInit } from '@angular/core';
import { CarroCompraService } from '../../services/carro-compra.service';
import { InformacionService } from '../../services/informacion.service';
import { Router } from '@angular/router';
import { ProductosService } from '../../services/productos.service';
import { Producto} from "../producto/producto";
import { DomSanitizer } from '@angular/platform-browser';
import { IMyDpOptions, IMyDateModel } from 'mydatepicker';
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
  public aceptaInstalacion1value: boolean = false
  public nombresInstalacion3value: string;
  public direccionInstalacion3value: string;
  public aceptaInstalacion2value: boolean = false
  public nombresInstalacion2value: string;
  public direccionInstalacion2value: string;
  public rutInstalacion2value:string;
  public aceptaInstalacion3value: boolean = false
  public tallerAsociadovalue: string;
  public fechaInstalacionvalue: string;
  public bloqueHorariovalue: string;
  public direccionInstalacion4value: string;
  public aceptaInstalacion4value: boolean = false
  public tipoInstalacion:number = 1;

  public costoNeumaticos:number = 0;
  //public costoInstalacion:number = 0;
  public descuentoAplicado:number = 0;
  public totalTotales:number = 0;
  public activaInstalacion: boolean = false;
  public activaErrorNoDisponible: boolean = false;
  
  errorMessage: string;

  public consesion:boolean = false;
  public myDatePickerOptions: IMyDpOptions = {
    // other options...
    dateFormat: 'dd/mm/yyyy',
    dayLabels: { su: 'Dom', mo: 'Lun', tu: 'Mar', we: 'Mie', th: 'Jue', fr: 'Vie', sa: 'Sab' },
    monthLabels:
    { 1: 'Ene', 2: 'Feb', 3: 'Mar', 4: 'Abr', 5: 'May', 6: 'Jun', 7: 'Jul', 8: 'Ago', 9: 'Sep', 10: 'Oct', 11: 'Nov', 12: 'Dic' },
    todayBtnTxt:'Hoy',
    width:'100%',
firstDayOfWeek:'mo',

disableUntil:{ year: 2018, month: 2, day: 3 },

disableWeekends:
false
  };


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
                this.consesion=true;

            }else{
                this.route.navigate(['/home']);
            }

          }else{
            //this.route.navigate(['/home']);
            this.consesion = false;
            this.getCarroAllSinSesion();


          }

      localStorage.setItem('instalacionTemporal', null);
    window.scrollTo(0, 0);
   }

  ngOnInit() {
    window.scrollTo(0, 0);

  }

  public classCaso1 = "tab-pane";
  public classCaso2 = "tab-pane";
  public classCaso3 = "tab-pane";
  public classCaso4 = "tab-pane";
  tipoInstalacionBoton(tipo: number):void{
        //this.validaRegion();
        this.tipoInstalacion = tipo;

        if(tipo==1){
          this.classCaso1 = "tab-pane active";
          this.classCaso2 = "tab-pane";
          this.classCaso3 = "tab-pane";
          this.classCaso4 = "tab-pane";
        }
    if (tipo == 2) {
      this.classCaso1 = "tab-pane";
      this.classCaso2 = "tab-pane active";
      this.classCaso3 = "tab-pane";
      this.classCaso4 = "tab-pane";
    }
    if (tipo == 3) {
      this.classCaso1 = "tab-pane";
      this.classCaso2 = "tab-pane";
      this.classCaso3 = "tab-pane active";
      this.classCaso4 = "tab-pane";
    }
    if (tipo == 4) {
      this.classCaso1 = "tab-pane";
      this.classCaso2 = "tab-pane";
      this.classCaso3 = "tab-pane";
      this.classCaso4 = "tab-pane active";
    }
        this.calculaTotales();
  }

 validaRegion = function(){
  // console.debug(this.regionInstalacion);
  var estado=true;
    if(typeof this.regionInstalacion == 'undefined'){
        this.regionValido = false;
       // this.errorMessage="Falta que seleccione la región de instalación";
        estado = false;
      }else{
      this.regionValido = true;
      }
      if(typeof this.ciudadInstalacion == 'undefined'){
       // this.regionValido = true;
        this.ciudadValido = false;
        //this.errorMessage="Falta que seleccione la ciudad de instalación";
        estado = false;
      }else{
        this.ciudadValido = true;
      }
      if(typeof this.comunaInstalacion == 'undefined'){
        //this.regionValido = true;
        //this.ciudadValido = true;
        this.comunaValido = false;
        //this.errorMessage="Falta que seleccione la comuna de instalación";
        estado = false;
      }else{
        this.comunaValido = true;
      }
   if (!estado)
      return;
        this.regionValido = true;
        this.ciudadValido = true;
        this.comunaValido = true;
      return true;
 }



   

public instalacionUno: boolean = false;
public instalacionDos: boolean = false;
public instalacionTres: boolean = false;
  public instalacionCuatro: boolean = false;
  public valorinstalacionUno: number = 0;
  public valorinstalacionDos: number = 0;
  public valorinstalacionTres: number = 0;
  public valorinstalacionCuatro: number=0;
  public getRandomArbitrary = function(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}
 public seleccionaInstalacion = function(comuna){
   this.validaRegion();
   //alert(this.id);
   if(typeof this.id === 'undefined'){
     // alert("nodefinido");

    var codigotempusuario = this.getRandomArbitrary(50000, 100000);
    var carroTemporal = JSON.parse(localStorage.getItem('carroUserTemporal'));
    //console.debug(carroTemporal);
    if (carroTemporal != null) {
      for (var i = 0; i < carroTemporal.length; i++) {
        this.carro.agregarCarro(carroTemporal[i].cantidad, carroTemporal[i].id_producto, codigotempusuario)
          .then(
            data => {
              this.generainstalacion(comuna, codigotempusuario);

            },
            error => {

            }
          );
      }

    }
   }else{
     this.generainstalacion(comuna,this.id);
   }
   
 }

public generainstalacion = function(comuna, usuario){

  this._is.getInstalacionByComuna(comuna, usuario).then(data => {
    console.debug(data);
    this.instalacionUno = false;
    this.instalacionDos = false;
    this.instalacionTres = false;
    this.instalacionCuatro = false;
    this.valorinstalacionUno = 0;
    this.valorinstalacionDos = 0;
    this.valorinstalacionTres = 0;
    this.valorinstalacionCuatro = 0;
    if (data.length == 0) {
      this.activaInstalacion = true;
      this.activaErrorNoDisponible = true;
    }
    var activado = 0;
    for (var i = 0; i < data.length; i++) {
      if (data[i].tipo == '1') {
        this.activaInstalacion = true;
        this.instalacionUno = true;
        this.valorinstalacionUno = data[i].valor;
        if (activado == 0) {
          this.tipoInstalacionBoton(1);
          activado = 1;
        }
      }
      if (data[i].tipo == '2') {
        this.activaInstalacion = true;
        this.instalacionDos = true;
        this.valorinstalacionDos = data[i].valor;
        if (activado == 0) {
          this.tipoInstalacionBoton(2);
          activado = 1;
        }
      }
      if (data[i].tipo == '3') {
        this.activaInstalacion = true;
        this.instalacionTres = true;
        this.valorinstalacionTres = data[i].valor;
        if (activado == 0) {
          this.tipoInstalacionBoton(3);
          activado = 1;
        }
      }
      if (data[i].tipo == '4') {
        this.activaInstalacion = true;
        this.instalacionCuatro = true;
        this.valorinstalacionCuatro = data[i].valor;
        if (activado == 0) {
          this.tipoInstalacionBoton(4);
          activado = 1;
        }
      }
    }
  });

}
 public aceptaInstalacion1Valido: boolean = false;

  guardaInstalacion1= function(){
     this.tipoInstalacion = 1;
     if(!this.validaRegion())
        return;

    
     //this.calculaTotales();
    if(!this.aceptaInstalacion1value){
      this.aceptaInstalacion1Valido=true;
      return;
    }else{
      this.aceptaInstalacion1Valido = false;
    }

    this.estado = true;
    this.errorMessage = "";
     this.guardaTemportalData();

  }
  
  public aceptaInstalacion2Valido: boolean = false;

  guardaInstalacion2= function(){
     this.tipoInstalacion = 2;
    if(!this.validaRegion())
        return;

    
    if (!this.aceptaInstalacion2value) {
      this.aceptaInstalacion2Valido = true;
      return;
    } else {
      this.aceptaInstalacion2Valido = false;
    }
    this.estado = true;
    this.errorMessage = "";
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
    
    if (!this.aceptaInstalacion3value) {
      this.aceptaInstalacion3Valido = true;
      return;
    } else {
      this.aceptaInstalacion3Valido = false;
    }
    this.estado = true;
    this.errorMessage = "";
     //this.calculaTotales();
     this.guardaTemportalData();
  }



  public direccionInstalacion4Valido: boolean = false;
  public aceptaInstalacion4Valido: boolean = false;
  guardaInstalacion4= function(){
     this.tipoInstalacion = 4;
    if(!this.validaRegion())
        return;


    //
    if (!this.aceptaInstalacion4value) {
      this.aceptaInstalacion4Valido = true;
      return;
    } else {
      this.aceptaInstalacion4Valido = false;
    }
    this.estado = true;
    this.errorMessage = "";
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
        nombresInstalacion3value: this.nombresInstalacion3value,
        direccionInstalacion3value: this.direccionInstalacion3value,
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
    this.validaRegion();
      this._is.getCiudades(selectedRegion);
      this._is.getTalleresByRegion(selectedRegion);
  }
  cambiaComuna(selectedCiudad: string): void{
    this.validaRegion();
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
  public nopuedecontinuar = false;
public checking = function(){

  if(!this.estado){
    this.validaRegion();
    this.nopuedecontinuar=true;
    return;
  }else{
    this.nopuedecontinuar = false;
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
  if (this.voucher == "" && this.descuentoAplicado>0){
    this.totalTotales += this.descuentoAplicado;
    this.descuentoAplicado=0;
  }  
  if(this.voucher == "")
    return;

  this._is.getDescuento(this.voucher).then(
    data=>{
      console.debug(data[0].valor);
      if (data[0].valor != 0 && this.descuentoAplicado==0){
        var valorporcentaje = parseInt(data[0].valor)/100;
        valorporcentaje = parseInt(this.totalTotales) * valorporcentaje;
        this.descuentoAplicado = Math.round(valorporcentaje);
        this.calculaTotales();
        }
    });
    //this.descuentoAplicado = 10000;

}
  }

