import { Component } from '@angular/core';

import { NavController } from 'ionic-angular';

import {Http} from "@angular/http";

@Component({
  selector: 'page-about',
  templateUrl: 'about.html'
})
export class AboutPage {

		posts: any;
	
		constructor(public http: Http) {
			 this.http.get('http://matera.chalon.codeur.online/apiProjetIonic2/api.php').map(res => res.json()).subscribe(data => {
        console.log(data);
        this.posts = data;
    });
 
  }
	
/*
  constructor(public navCtrl: NavController) {

  }
*/

}