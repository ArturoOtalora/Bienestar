export class Empresa {
    id: number;
    nombre: string;
}

export class Docente {
    id: number;
    usuario_id:number;
}

export class Oferta {
    id: number;
    titulo: string;
    detalle: string;
    vacantes: number;
    contacto: string;
    tipo_oferta: string;
    empresa_id: number;
    estado: boolean;
    fecha_fin: Date;
    aplicado: boolean;
    empresa_nombre: string;
    nombre: string;
    apellidos: string;
    correo: string;
}

export class Permiso {
    id: number;
    componente: string;
    titulo: string;
}

export class Rol {
    id: number;
    nombre: string;
}


export class Usuario {
    id: number;
    nombre: string;
    correo: string;
    documento: number;
    token: string;
    rol_usuario: RolUsuario[];
    file_curriculum:any;
}

export class RolUsuario {
    usuario_id: number;
    rol_id: number;
    rol: Rol;
}

export class AlumnoOferta {
    id: number;
    alumno_id: number;
    oferta_id: number;
}

export class Facultad {
    id: number;
    nombre: string;
}

export class Carrera {
    id: number;
    nombre: string;
    facultad_id: number;
    facultad: Facultad;
}

export class Diplomado {
    id: number;
    nombre: string;
    fecha_inicio: Date;
    fecha_fin: Date;
    facultad_id: number;
    facultad_nombre: string;
    estado: boolean;
    vacantes: number;
    alumnos_inscritos: number;
    alumnos: Alumno[];
    inscrito: boolean;
}

export class Alumno {
    id: number;
    usuario_id:number;
    file_curriculum:any;
}

export class Actividad {
    id: number;
    nombre: string;
    detalle: string;
    poster: string;
    fecha_inicio: Date;
    fecha_fin: Date;
    tipo_actividad_id: number;
    tipo_actividad: TipoActividad;
}

export class TipoActividad {
    id: number;
    nombre: string;
}

export class Foto {
    id: number;
    actividad_id: number;
    imagen: string;
}

export class Pasantia {
    id?: number;
    fecha_inicio: Date;
    fecha_fin: Date;
    file_carta: string;
    file_evaluacion: string;
    file_certificado: string;
    estado: boolean;
    empresa_id: number;
    alumno_id: number;
    alumno_nombre: string;
    empresa_nombre: string;
    observaciones: string;
}

export class Menu {
    id: number;
    permiso: Permiso;
    permiso_id: number;
    rol: Rol;
    rol_id: Rol;
}

