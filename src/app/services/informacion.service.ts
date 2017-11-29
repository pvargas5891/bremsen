import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

@Injectable()
export class InformacionService {

  info:any = {};
  constructor( public http:Http ) {

    this.http.get("assets/data/info.paginas.json")
             .subscribe( data =>{
               console.debug(data.json());
               this.info = data.json();
             })
  }

}
