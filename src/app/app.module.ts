import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { FormsModule } from '@angular/forms';
import { NgxPaginationModule } from 'ngx-pagination';
import { NgAutoCompleteModule } from "ng-auto-complete";
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
import { InstalacionComponent } from './components/instalacion/instalacion.component';
import { TerminosComponent } from './components/terminos/terminos.component';
import { PreguntasComponent } from './components/preguntas/preguntas.component';
import { BremsenComponent } from './components/bremsen/bremsen.component';
import { BlogComponent } from './components/blog/blog.component';
import { OlvidoComponent } from './components/olvido/olvido.component';



@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    RegistroComponent,
    CategoriaFiltradaComponent,
    CategoriaNoFiltradaComponent,
    ProductoComponent,
    InstalacionComponent,
    TerminosComponent,
    PreguntasComponent,
    BremsenComponent,
    BlogComponent,
    OlvidoComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    FormsModule,
    app_routing,
    NgxPaginationModule,
    NgAutoCompleteModule
  ],
  providers: [
    InformacionService,
    ProductosService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
