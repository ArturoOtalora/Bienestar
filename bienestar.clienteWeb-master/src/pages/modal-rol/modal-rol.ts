import { UsuarioProvider } from './../../providers/usuario/usuario';
import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { MenuPage } from '../menu/menu';

@Component({
  selector: 'page-modal-rol',
  templateUrl: 'modal-rol.html',
})
export class ModalRolPage {

  roles: any;
  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private user: UsuarioProvider) {

    this.roles = this.user.getUsuario().rol_usuario
  }

  abrirMenu(rol: any) {
    console.log(rol);
    this.user.setRol(rol);
    this.navCtrl.setRoot(MenuPage);
  }

}
