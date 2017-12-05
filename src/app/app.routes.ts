import {RouterModule, Routes} from '@angular/router';

import {
  HomeComponent,
  RegistroComponent,
  CategoriaFiltradaComponent
} from "./components/index.paginas";

const app_routes: Routes = [

    { path: 'home', component: HomeComponent },
    { path: 'registro', component: RegistroComponent },
    { path: 'filtrado', component: CategoriaFiltradaComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'home'}

];

export const app_routing = RouterModule.forRoot(app_routes, {useHash: true});
