import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ToastController } from 'ionic-angular';
import { FormGroup, FormBuilder, Validators } from '../../../node_modules/@angular/forms';
import { HomePage } from '../home/home';

@Component({
  selector: 'page-registro-alumno',
  templateUrl: 'registro-alumno.html',
})
export class RegistroAlumnoPage {

  frmRegistro: FormGroup;
  inicio: any;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private frmBuilder: FormBuilder,
    private http: HttpProvider,
    private toastCtrl: ToastController, ) {

    this.frmRegistro = this.frmBuilder.group({
      correo: ['', Validators.compose([Validators.required, Validators.email])],
      nombre: ['', Validators.compose([Validators.required, Validators.pattern('[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{3,}')])],
      documento: ['', Validators.compose([Validators.required, Validators.minLength(8), Validators.maxLength(10), Validators.pattern('\\d+')])],
    });
    this.inicio=HomePage;
  }



  registro() {
    this.http.post('usuario/alumno/', this.frmRegistro.value).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'Usuario registrado con éxito',
          duration: 1500
        });
        toast.present();
        this.navCtrl.pop();
      }
      else {
        let toast = this.toastCtrl.create({
          message: data.mensaje,
          duration: 1500
        });
        toast.present();
      }
    });
  }
}
