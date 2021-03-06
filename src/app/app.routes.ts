import {RouterModule, Routes} from '@angular/router';

import {
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
  MisdatosComponent,
  CarroComponent,
  CheckoutInComponent,
  CheckoutOutComponent,
  SearchComponent,
  ExitoComponent,
  FracasoComponent,
  ContenidoComponent
} from "./components/index.paginas";

const app_routes: Routes = [

    { path: 'home', component: HomeComponent },
    { path: 'registro', component: RegistroComponent },
    { path: 'filtrada/:param1/:param2/:param3/:origen', component: CategoriaFiltradaComponent},
    { path: 'categoria', component: CategoriaNoFiltradaComponent},
    { path: 'instalacion', component: InstalacionComponent},
    { path: 'terminos', component: TerminosComponent},
    { path: 'preguntas', component: PreguntasComponent},
    { path: 'bremsen', component: BremsenComponent},
    { path: 'blog', component: BlogComponent},
    { path: 'olvido', component: OlvidoComponent},
    { path: 'carro', component: CarroComponent},
    { path: 'checkin', component: CheckoutInComponent},
    { path: 'checkout', component: CheckoutOutComponent},
    { path: 'contenido/:id', component: ContenidoComponent },
    { path: 'producto/:id', component: ProductoComponent},
    { path: 'misdatos', component: MisdatosComponent},
    { path: 'exito/:id', component: ExitoComponent},
    { path: 'fracaso/:id', component: FracasoComponent},
    { path: 'search/:origen/:data', component: SearchComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'home'}

];

export const app_routing = RouterModule.forRoot(app_routes, {useHash: true});
