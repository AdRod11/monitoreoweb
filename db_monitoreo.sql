create table estado(id serial primary key, descripcion varchar(50));

create table servicio(id serial primary key,nombre varchar(50), descripcion varchar(50),comando text);

create table sistema(id serial primary key, nombre varchar(50), version varchar(10));

create table ubicacion(id serial primary key, descripcion varchar(50), lugar varchar(50));

create table categoria(id serial primary key, descripcion varchar(50));

create table dia(id serial primary key, descripcion varchar(50));

create table periodo(id serial primary key, id_dia int,  constraint dia_fk foreign key (id_dia) references dia(id));

create table rol(id serial primary key, descripcion varchar(50));

create table persona(id serial primary key, nombre varchar(50) not null, a_paterno varchar(50) not null, a_materno varchar(50), curp varchar(18) not null, rfc varchar(10), correo varchar(50), telefono varchar(15),domicilio varchar(50));

create table responsable(id serial primary key, id_persona int, id_rol int, constraint persona_fk foreign key (id_persona) references persona(id), constraint rol_fk foreign key (id_rol) references rol(id));

create table grupo(id serial primary key, descripcion varchar(50), id_rol int, constraint rol_fk foreign key (id_rol) references rol(id));

create table dispositivo(id serial primary key, ip varchar(15), nombre  varchar(50), mac varchar(35), comando text, id_grupo int, id_sistema int, id_ubicacion int, id_categoria int, id_periodo int, constraint grupo_fk foreign key (id_grupo) references grupo(id), constraint sistema_fk foreign key (id_sistema) references sistema(id), constraint ubicacion_fk foreign key (id_ubicacion) references ubicacion(id), constraint categoria_fk foreign key (id_categoria) references categoria(id), constraint periodo_fk foreign key (id_periodo) references periodo(id));

create table usuario(id serial primary key, usuario varchar(50), contrasena varchar(32), estatus bool, id_persona int, constraint persona_fk foreign key (id_persona) references persona(id));

create table usuario_rol(id serial primary key, id_rol int, id_usuario int, constraint rol_fk foreign key (id_rol) references rol(id), constraint usuario_fk foreign key (id_usuario) references usuario(id));

create table bitacora(id serial primary key, token varchar(32), id_usuario int, fecha_inicio timestamp, fecha_fin timestamp, constraint usuario_fk foreign key (id_usuario) references usuario(id));

create table responsable_dispositivo(id serial primary key, id_responsable int, id_dispositivo int, constraint  responsable_fk foreign key (id_responsable) references responsable(id), constraint dispositivo_fk foreign key (id_dispositivo) references dispositivo(id));

create table notificacion_personalizada(id serial primary key, id_responsable int, id_grupo int, mensaje varchar(50), constraint responsable_fk foreign key (id_responsable) references responsable(id), constraint grupo_fk foreign key (id_grupo) references grupo(id));

create table dispositivo_servicio(id serial primary key, id_dispositivo int, id_servicio int, id_estado int, mensaje varchar(200), constraint dispositivo_fk foreign key (id_dispositivo) references dispositivo(id), constraint servicio_fk foreign key (id_servicio) references servicio(id), constraint estado_fk foreign key (id_estado) references estado(id));

create table historico(id serial primary key, id_dispositivo_servicio int, fecha timestamp, estatus varchar(200), mensaje varchar(200), constraint dispositivo_servicio_fk foreign key (id_dispositivo_servicio) references dispositivo_servicio(id));



