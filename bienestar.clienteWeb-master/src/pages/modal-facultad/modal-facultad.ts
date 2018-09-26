import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { HttpProvider } from '../../providers/http/http';
import { Facultad } from '../../modelos/modelos';

@Component({
  selector: 'page-modal-facultad',
  templateUrl: 'modal-facultad.html',
})
export class ModalFacultadPage {

  facultad: Facultad;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private viewCtrl: ViewController,
    private http: HttpProvider,
    private toastCtrl: ToastController) {

    if (this.navParams.get('data')) {
      this.facultad = this.navParams.get('data');
    } else {
      this.facultad = new Facultad();
    }
  }

  guardar() {
    if (!this.facultad.nombre) {
      const toast = this.toastCtrl.create({
        message: "hay campos vacíos",
        duration: 3000
      });
      toast.present();
    }
    else {
      if (this.facultad.id) {
        this.http.put('facultad/' + this.facultad.id, this.facultad).then((data: any) => this.viewCtrl.dismiss());
      } else {
        this.http.post('facultad', this.facultad).then((data: any) => this.viewCtrl.dismiss());
      }
    }
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

}
