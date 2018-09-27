import { Component } from '@angular/core';
import { NavController, NavParams, ToastController, ViewController } from 'ionic-angular';
import { HttpProvider } from '../../providers/http/http';
import { Empresa, Usuario } from '../../modelos/modelos';
import { FormGroup, FormBuilder, Validators } from '../../../node_modules/@angular/forms';

@Component({
  selector: 'page-modal-usuario',
  templateUrl: 'modal-usuario.html',
})
export class ModalUsuario {

  usuario: Usuario;
  tipo:any;
  recurso:any;
  frmRegistro: FormGroup;
  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private viewCtrl: ViewController,
    private http: HttpProvider,
    private toastCtrl: ToastController,
    private frmBuilder: FormBuilder) {


    this.frmRegistro = this.frmBuilder.group({
      correo: ['', Validators.compose([Validators.required, Validators.email])],
      nombre: ['', Validators.compose([Validators.required, Validators.pattern('[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{3,}')])],
      documento: ['', Validators.compose([Validators.required, Validators.minLength(8), Validators.maxLength(10), Validators.pattern('\\d+')])],
    });
    console.log('data recibida');
    console.log(this.navParams.get('data'));
    this.tipo = this.navParams.get('tipo');
    if (this.navParams.get('data')) {   
      this.usuario = this.navParams.get('data');
      console.log(this.usuario.id);
      this.frmRegistro.get("correo").setValue(this.usuario.correo);
      this.frmRegistro.get("nombre").setValue(this.usuario.nombre);
      this.frmRegistro.get("nombre").disable();
      this.frmRegistro.get("documento").setValue(this.usuario.documento);
      this.frmRegistro.get("documento").disable();
    }
    else{
      this.usuario=new Usuario();
      this.frmRegistro.get("nombre").enable();
      this.frmRegistro.get("documento").enable();
    } 
  }

  registro() {
    if (this.tipo=='Docente'){
      this.recurso='usuario/docente/'
    }
    else{
      this.recurso='usuario/administrador/'
    }
 
    if (this.usuario.id) {     
      this.http.put('usuario/' + this.usuario.id, this.frmRegistro.value).then((data: any) => {
        if (data.estado) {
          let toast = this.toastCtrl.create({
            message: 'Usuario actualizado con éxito',
            duration: 1500
          });
          toast.present();
          this.viewCtrl.dismiss()
        }
        else {
          let toast = this.toastCtrl.create({
            message: data.mensaje,
            duration: 1500
          });
          toast.present();
        }
      });             
  } else {
    this.http.post(this.recurso, this.frmRegistro.value).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'Usuario creado con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss()
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


  dismiss() {
    this.viewCtrl.dismiss();
  }

}
