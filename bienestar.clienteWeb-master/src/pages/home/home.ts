import { MenuPage } from './../menu/menu';
import { ModalRolPage } from './../modal-rol/modal-rol';
import { RegistroAlumnoPage } from './../registro-alumno/registro-alumno';
import { UsuarioProvider } from '../../providers/usuario/usuario';
import { HttpProvider } from '../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, ToastController, ModalController } from 'ionic-angular';
import { FormGroup, FormBuilder, Validators } from '../../../node_modules/@angular/forms';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})

export class HomePage {

  frmLogin: FormGroup;
  registroAlumno: any;

  constructor(public navCtrl: NavController,
    private toastCtrl: ToastController,
    private http: HttpProvider,
    private user: UsuarioProvider,
    private frmBuilder: FormBuilder,
    private modalCtrl: ModalController) {

    this.registroAlumno = RegistroAlumnoPage;

    this.frmLogin = this.frmBuilder.group({
      documento: ['', Validators.compose([Validators.required, Validators.minLength(8), Validators.maxLength(10), Validators.pattern('\\d+')])],
      contrasena: ['', Validators.required],
    });

  }



  login() {
    this.http.post('usuario/login/', this.frmLogin.value).then((data: any) => {
      if (data.estado) {
     
        this.http.get('usuario/alumno/' + data.data.id).then((datacurri: any) => {
          let file=null;
          if(datacurri.data === null){
            file=null;
          }
          else{
            file=datacurri.data.file_curriculum;
          }
          this.user.setUsuario(data.data,file);
          let toast = this.toastCtrl.create({
            message: 'Bienvenido ' + data.data.nombre,
            duration: 1500,
            position: 'top'
          });
          toast.present();
          if (data.data.rol_usuario) {
            if (Object.keys(data.data.rol_usuario).length == 1) {
              this.user.setRol(data.data.rol_usuario[0].rol);
              this.navCtrl.setRoot(MenuPage);
            }
            else {
              const modal = this.modalCtrl.create(ModalRolPage);
              modal.present();
            }
          }
          else {
            let toast = this.toastCtrl.create({
              message: 'El usuario no tiene roles asignados',
              duration: 1500,
              position: 'top'
            });
            toast.present();
          }
            });

       
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
