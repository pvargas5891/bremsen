import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { FormsModule } from '@angular/forms';
//RUTAS
import { app_routing }  from "./app.routes";

//servicios
import { InformacionService } from "./services/informacion.service";
import { ProductosService } from './services/productos.service';
//Componentes
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { HomeComponent } from './components/home/home.component';
import { RegistroComponent } from './components/registro/registro.component';
import { CategoriaFiltradaComponent } from './components/categoria-filtrada/categoria-filtrada.component';
import { CategoriaNoFiltradaComponent } from './components/categoria-no-filtrada/categoria-no-filtrada.component';
import { ProductoComponent } from './components/producto/producto.component';



@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    RegistroComponent,
    CategoriaFiltradaComponent,
    CategoriaNoFiltradaComponent,
    ProductoComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    app_routing
  ],
  providers: [
    InformacionService,
    ProductosService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
