import { Component, OnInit } from '@angular/core';
import { InformacionService} from "../../services/informacion.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html'
})
export class HomeComponent {

  constructor( public _is:InformacionService) { }

}
