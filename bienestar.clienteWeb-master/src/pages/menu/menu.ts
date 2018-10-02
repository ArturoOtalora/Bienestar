import { UsuarioProvider } from './../../providers/usuario/usuario';
import { HttpProvider } from './../../providers/http/http';
import { Component, ViewChild } from '@angular/core';
import { NavController, NavParams, Nav, ToastController } from 'ionic-angular';
import { OfertaPage } from '../oferta/oferta';
import { PasantiaPage } from '../pasantia/pasantia';
import { DiplomadoPage } from '../diplomado/diplomado';
import { ActividadPage } from '../actividad/actividad';
import { UsuarioPage } from '../usuario/usuario';
import { ConfiguracionPage } from '../configuracion/configuracion';
import { Menu } from '../../modelos/modelos';
import { HomePage } from '../home/home';

@Component({
  selector: 'page-menu',
  templateUrl: 'menu.html',
})
export class MenuPage {
  @ViewChild('nav') nav: Nav;
  rootPage: any;
  ofertaPage: any;
  titulo: string;
  platform: string;
  menu: Menu;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    private user: UsuarioProvider,
    private toastCtrl: ToastController) {

    this.getPermisos();

  }

  getPermisos() {

    this.http.get('permiso/porRol/' + this.user.getRol().id).then((data: any) => {
      // this.menu = data.data
      this.menu = data.data;
      this.abrirPagina(this.menu[0].permiso);
    });
  }


  abrirPagina(item: any) {

    switch (item.componente) {
      case 'OfertaPage':
        item.componente = OfertaPage;
        break;
      case 'PasantiaPage':
        item.componente = PasantiaPage;
        break;
      case 'DiplomadoPage':
        item.componente = DiplomadoPage;
        break;
      case 'ActividadPage':
        item.componente = ActividadPage;
        break;
      case 'UsuarioPage':
        item.componente = UsuarioPage;
        break;
      case 'ConfiguracionPage':
        item.componente = ConfiguracionPage;
        break;
    }

    this.titulo = item.titulo;
    this.nav.setRoot(item.componente);
  }

  cerrarSesion() {
    const toast = this.toastCtrl.create({
      message: "Cerrando sesión",
      duration: 3000
    });
    toast.present();
    this.navCtrl.setRoot(HomePage);
  }

}
