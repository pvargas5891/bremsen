import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { FormsModule } from '@angular/forms';
import { NgxPaginationModule } from 'ngx-pagination';
import { NgAutoCompleteModule } from "ng-auto-complete";
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
//RUTAS
import { app_routing }  from "./app.routes";

//servicios
import { InformacionService } from "./services/informacion.service";
import { ProductosService } from './services/productos.service';


import { fakeBackendProvider } from './_helpers/index';

import { AlertComponent } from './_directives/index';
import { AuthGuard } from './_guards/index';
import { JwtInterceptor } from './_helpers/index';
import { AlertService, AuthenticationService, UserService } from './_services/index'

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
    OlvidoComponent,
    AlertComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    HttpClientModule,
    FormsModule,
    app_routing,
    NgxPaginationModule,
    NgAutoCompleteModule
  ],
  providers: [
    InformacionService,
    ProductosService,
    AuthGuard,
    AlertService,
    AuthenticationService,
    UserService,
    {
        provide: HTTP_INTERCEPTORS,
        useClass: JwtInterceptor,
        multi: true
    },

    // provider used to create fake backend
    fakeBackendProvider
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
