import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ToastController } from 'ionic-angular';
import { Actividad, Foto } from '../../modelos/modelos';

@Component({
  selector: 'page-detalle-actividad',
  templateUrl: 'detalle-actividad.html',
})
export class DetalleActividadPage {

  actividad: Actividad;
  foto: Foto;
  fotos: Foto[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    private toastCtrl: ToastController) {

    this.actividad = new Actividad();
    this.foto = new Foto();
    this.actividad = this.navParams.get('actividad');
    this.getFotos();
  }

  getFotos() {
    this.http.get('actividad/getFotos/' + this.actividad.id).then((data: any) => this.fotos = data.data)
  }

  subirFoto($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.foto.imagen = myReader.result;
    }
    myReader.readAsDataURL(file);
  }

  enviarFoto() {
    this.foto.actividad_id = this.actividad.id;
    this.http.post('actividad/subirFoto', this.foto).then((data: any) => {

      let toast = this.toastCtrl.create({
        message: 'Imagen insertada con éxito',
        duration: 1500
      });
      toast.present();
      this.getFotos();
    });
  }
}
