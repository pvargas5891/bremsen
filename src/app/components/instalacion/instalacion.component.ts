import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-instalacion',
  templateUrl: './instalacion.component.html',
  styles: []
})
export class InstalacionComponent implements OnInit {
  public sinsesion: boolean=true;
  constructor() { 
    window.scrollTo(0, 0);

    var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){

              this.sinsesion=false;

            }

          }

  }

  ngOnInit() {
  }

}
