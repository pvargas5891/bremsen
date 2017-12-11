import {RouterModule, Routes} from '@angular/router';

import {
  HomeComponent,
  RegistroComponent,
  CategoriaFiltradaComponent,
  CategoriaNoFiltradaComponent,
  ProductoComponent
} from "./components/index.paginas";

const app_routes: Routes = [

    { path: 'home', component: HomeComponent },
    { path: 'registro', component: RegistroComponent },
    { path: 'filtrada/:param1/:param2/:param3/:origen', component: CategoriaFiltradaComponent},
    { path: 'categoria', component: CategoriaNoFiltradaComponent},
    { path: 'producto/:id', component: ProductoComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'home'}

];

export const app_routing = RouterModule.forRoot(app_routes, {useHash: true});
