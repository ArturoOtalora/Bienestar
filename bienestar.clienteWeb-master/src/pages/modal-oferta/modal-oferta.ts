import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { Oferta, Empresa } from '../../modelos/modelos';

@Component({
  selector: 'page-modal-oferta',
  templateUrl: 'modal-oferta.html',
})
export class ModalOfertaPage {

  oferta: Oferta;
  empresas: Empresa[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    public viewCtrl: ViewController,
    private toastCtrl: ToastController) {

    if (this.navParams.get('oferta')) {
      this.oferta = this.navParams.get('oferta');
    } else {
      this.oferta = new Oferta();
    }

    this.http.get('empresa').then((data: any) => {
      this.empresas = data.data;
    });

  }

  guardarOferta(oferta: any) {

    if (!oferta.titulo || !oferta.detalle || !oferta.contacto ||
      !oferta.empresa_id || !oferta.tipo_oferta || !oferta.vacantes || !oferta.fecha_fin) {
      let toast = this.toastCtrl.create({
        message: 'Hay campos vacíos',
        duration: 1500
      });
      toast.present();
    }
    else {
      if (this.oferta.id) {
        this.editar(oferta);
      }
      else {
        this.crear(oferta);
      }
    }
  }

  editar(oferta: any) {

    this.http.put('oferta/' + oferta.id, oferta).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'oferta editada con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss();
      }
    });
  }
  crear(oferta: Oferta) {

    this.http.post('oferta', oferta).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'oferta creada con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss();
      }
      else {
        let toast = this.toastCtrl.create({
          message: 'error creando la oferta',
          duration: 1500
        });
        toast.present();
        console.log(data.detalles);
      }
    });
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }
}
