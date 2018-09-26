import { Component } from '@angular/core';
import { NavController, NavParams, ToastController, ViewController } from 'ionic-angular';
import { HttpProvider } from '../../providers/http/http';
import { Empresa } from '../../modelos/modelos';

@Component({
  selector: 'page-modal-empresa',
  templateUrl: 'modal-empresa.html',
})
export class ModalEmpresaPage {

  empresa: Empresa;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private viewCtrl: ViewController,
    private http: HttpProvider,
    private toastCtrl: ToastController) {

    if (this.navParams.get('data')) {
      this.empresa = this.navParams.get('data');
    } else {
      this.empresa = new Empresa();
    }
  }
  guardar() {
    if (!this.empresa.nombre) {
      const toast = this.toastCtrl.create({
        message: "hay campos vacíos",
        duration: 3000
      });
      toast.present();
    }
    else {
      if (this.empresa.id) {
        this.http.put('empresa/' + this.empresa.id, this.empresa).then((data: any) => this.viewCtrl.dismiss());
      } else {
        this.http.post('empresa', this.empresa).then((data: any) => this.viewCtrl.dismiss());
      }
    }
  }


  dismiss() {
    this.viewCtrl.dismiss();
  }

}
