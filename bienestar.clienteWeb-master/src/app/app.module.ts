import { ModalRolPage } from './../pages/modal-rol/modal-rol';
import { RegistroAlumnoPage } from './../pages/registro-alumno/registro-alumno';
import { ModalTipoActividadPage } from './../pages/modal-tipo-actividad/modal-tipo-actividad';
import { ModalCarreraPage } from './../pages/modal-carrera/modal-carrera';
import { ModalEmpresaPage } from './../pages/modal-empresa/modal-empresa';
import { DetalleActividadPage } from './../pages/detalle-actividad/detalle-actividad';
import { ModalActividadPage } from './../pages/modal-actividad/modal-actividad';
import { ConfiguracionPage } from './../pages/configuracion/configuracion';
import { PasantiaPage } from './../pages/pasantia/pasantia';
import { ActividadPage } from './../pages/actividad/actividad';
import { ModalDiplomadoPage } from './../pages/modal-diplomado/modal-diplomado';
import { DiplomadoPage } from './../pages/diplomado/diplomado';
import { ModalOfertaPage } from '../pages/modal-oferta/modal-oferta';
import { OfertaPage } from '../pages/oferta/oferta';
import { MenuPage } from '../pages/menu/menu';
import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { HttpProvider } from '../providers/http/http';
import { HttpClientModule } from '@angular/common/http';
import { UsuarioProvider } from '../providers/usuario/usuario';
import { UsuarioPage } from '../pages/usuario/usuario';
import { ModalFacultadPage } from '../pages/modal-facultad/modal-facultad';
import { ModalUsuario } from '../pages/modal-usuario/modal-usuario';

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    RegistroAlumnoPage,
    MenuPage,
    OfertaPage,
    ModalOfertaPage,
    DiplomadoPage,
    ModalDiplomadoPage,
    ActividadPage,
    PasantiaPage,
    UsuarioPage,
    ConfiguracionPage,
    ModalActividadPage,
    DetalleActividadPage,
    ModalEmpresaPage,
    ModalFacultadPage,
    ModalCarreraPage,
    ModalTipoActividadPage,
    ModalRolPage,
    ModalUsuario
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
    HttpClientModule
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    RegistroAlumnoPage,
    MenuPage,
    OfertaPage,
    ModalOfertaPage,
    DiplomadoPage,
    ModalDiplomadoPage,
    ActividadPage,
    PasantiaPage,
    UsuarioPage,
    ConfiguracionPage,
    ModalActividadPage,
    DetalleActividadPage,
    ModalEmpresaPage,
    ModalFacultadPage,
    ModalCarreraPage,
    ModalTipoActividadPage,
    ModalRolPage,
    ModalUsuario
  ],
  providers: [
    StatusBar,
    SplashScreen,
    { provide: ErrorHandler, useClass: IonicErrorHandler },
    HttpProvider,
    UsuarioProvider
  ]
})
export class AppModule { }
