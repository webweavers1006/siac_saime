--
-- PostgreSQL database dump
--

-- Dumped from database version 13.10 (Ubuntu 13.10-1.pgdg18.04+1)
-- Dumped by pg_dump version 13.10 (Ubuntu 13.10-1.pgdg18.04+1)

-- Started on 2023-10-23 15:18:30 -04

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 233 (class 1259 OID 136057)
-- Name: sgc_auditoria_sistema; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_auditoria_sistema (
    audi_id integer NOT NULL,
    audi_user_id integer NOT NULL,
    audi_accion text NOT NULL,
    audi_fecha date DEFAULT CURRENT_DATE NOT NULL,
    audi_hora character(11)
);


ALTER TABLE public.sgc_auditoria_sistema OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 136055)
-- Name: sgc_auditoria_sistema_audi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_auditoria_sistema_audi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_auditoria_sistema_audi_id_seq OWNER TO postgres;

--
-- TOC entry 3295 (class 0 OID 0)
-- Dependencies: 232
-- Name: sgc_auditoria_sistema_audi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_auditoria_sistema_audi_id_seq OWNED BY public.sgc_auditoria_sistema.audi_id;


--
-- TOC entry 225 (class 1259 OID 126581)
-- Name: sgc_casos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_casos (
    idcaso integer NOT NULL,
    casofec date NOT NULL,
    casoced character varying(48) NOT NULL,
    casonom character varying(48) NOT NULL,
    casoape character varying(48) NOT NULL,
    casotel character varying(48) NOT NULL,
    casonumsol character varying(48) NOT NULL,
    idest integer NOT NULL,
    idrrss integer NOT NULL,
    idusuopr integer NOT NULL,
    estadoid integer NOT NULL,
    municipioid integer NOT NULL,
    parroquiaid integer NOT NULL,
    ofiid integer NOT NULL,
    casodesc character varying(4096) NOT NULL,
    id_tipo_atencion integer DEFAULT 0,
    sexo integer,
    caso_nacionalidad character varying(1),
    borrado boolean DEFAULT false,
    tipo_beneficiario integer DEFAULT 1,
    direccion text,
    correo text,
    ente_adscrito_id integer,
    caso_hora text
);


ALTER TABLE public.sgc_casos OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 136120)
-- Name: sgc_casos_denuncias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_casos_denuncias (
    denu_id integer NOT NULL,
    denu_afecta_persona boolean DEFAULT false NOT NULL,
    denu_afecta_comunidad boolean DEFAULT false NOT NULL,
    denu_afecta_terceros boolean DEFAULT false NOT NULL,
    denu_involucrados text,
    denu_fecha_hechos date DEFAULT CURRENT_DATE NOT NULL,
    denu_instancia_popular text,
    denu_rif_instancia text,
    denu_ente_financiador text,
    denu_nombre_proyecto text,
    denu_monto_aprovado text,
    denu_id_caso integer,
    denu_borrado boolean DEFAULT false
);


ALTER TABLE public.sgc_casos_denuncias OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 136118)
-- Name: sgc_casos_denuncias_denu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_casos_denuncias_denu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_casos_denuncias_denu_id_seq OWNER TO postgres;

--
-- TOC entry 3296 (class 0 OID 0)
-- Dependencies: 238
-- Name: sgc_casos_denuncias_denu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_casos_denuncias_denu_id_seq OWNED BY public.sgc_casos_denuncias.denu_id;


--
-- TOC entry 224 (class 1259 OID 126579)
-- Name: sgc_casos_idcaso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_casos_idcaso_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_casos_idcaso_seq OWNER TO postgres;

--
-- TOC entry 3297 (class 0 OID 0)
-- Dependencies: 224
-- Name: sgc_casos_idcaso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_casos_idcaso_seq OWNED BY public.sgc_casos.idcaso;


--
-- TOC entry 235 (class 1259 OID 136101)
-- Name: sgc_casos_remitidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_casos_remitidos (
    casos_re_id integer NOT NULL,
    casos_id integer NOT NULL,
    direccion_id integer NOT NULL,
    borrado boolean DEFAULT false NOT NULL,
    idusuop integer
);


ALTER TABLE public.sgc_casos_remitidos OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 136099)
-- Name: sgc_casos_remitidos_casos_re_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_casos_remitidos_casos_re_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_casos_remitidos_casos_re_id_seq OWNER TO postgres;

--
-- TOC entry 3298 (class 0 OID 0)
-- Dependencies: 234
-- Name: sgc_casos_remitidos_casos_re_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_casos_remitidos_casos_re_id_seq OWNED BY public.sgc_casos_remitidos.casos_re_id;


--
-- TOC entry 245 (class 1259 OID 136231)
-- Name: sgc_direcciones_administrativas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_direcciones_administrativas (
    id integer NOT NULL,
    descripcion text NOT NULL,
    borrado boolean DEFAULT false NOT NULL
);


ALTER TABLE public.sgc_direcciones_administrativas OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 136229)
-- Name: sgc_direcciones_administrativas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_direcciones_administrativas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_direcciones_administrativas_id_seq OWNER TO postgres;

--
-- TOC entry 3299 (class 0 OID 0)
-- Dependencies: 244
-- Name: sgc_direcciones_administrativas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_direcciones_administrativas_id_seq OWNED BY public.sgc_direcciones_administrativas.id;


--
-- TOC entry 241 (class 1259 OID 136169)
-- Name: sgc_documentos_casos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_documentos_casos (
    docu_id integer NOT NULL,
    docu_id_caso integer NOT NULL,
    docu_ruta text NOT NULL
);


ALTER TABLE public.sgc_documentos_casos OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 136167)
-- Name: sgc_documentos_casos_docu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_documentos_casos_docu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_documentos_casos_docu_id_seq OWNER TO postgres;

--
-- TOC entry 3300 (class 0 OID 0)
-- Dependencies: 240
-- Name: sgc_documentos_casos_docu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_documentos_casos_docu_id_seq OWNED BY public.sgc_documentos_casos.docu_id;


--
-- TOC entry 243 (class 1259 OID 136180)
-- Name: sgc_ente_asdcrito; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_ente_asdcrito (
    ente_id integer NOT NULL,
    ente_nombre text NOT NULL,
    borrado boolean DEFAULT false NOT NULL
);


ALTER TABLE public.sgc_ente_asdcrito OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 136178)
-- Name: sgc_ente_asdcrito_ente_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_ente_asdcrito_ente_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_ente_asdcrito_ente_id_seq OWNER TO postgres;

--
-- TOC entry 3301 (class 0 OID 0)
-- Dependencies: 242
-- Name: sgc_ente_asdcrito_ente_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_ente_asdcrito_ente_id_seq OWNED BY public.sgc_ente_asdcrito.ente_id;


--
-- TOC entry 200 (class 1259 OID 124898)
-- Name: sgc_estados; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_estados (
    estadoid integer NOT NULL,
    estadonom character varying(48) NOT NULL,
    paisid integer NOT NULL,
    borrado boolean DEFAULT false
);


ALTER TABLE public.sgc_estados OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 124901)
-- Name: sgc_estados_estadoid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_estados_estadoid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_estados_estadoid_seq OWNER TO postgres;

--
-- TOC entry 3302 (class 0 OID 0)
-- Dependencies: 201
-- Name: sgc_estados_estadoid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_estados_estadoid_seq OWNED BY public.sgc_estados.estadoid;


--
-- TOC entry 202 (class 1259 OID 124903)
-- Name: sgc_estatus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_estatus (
    idest integer NOT NULL,
    estnom character varying(48) NOT NULL
);


ALTER TABLE public.sgc_estatus OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 124906)
-- Name: sgc_estatus_idest_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_estatus_idest_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_estatus_idest_seq OWNER TO postgres;

--
-- TOC entry 3303 (class 0 OID 0)
-- Dependencies: 203
-- Name: sgc_estatus_idest_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_estatus_idest_seq OWNED BY public.sgc_estatus.idest;


--
-- TOC entry 204 (class 1259 OID 124908)
-- Name: sgc_estatus_llamadas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_estatus_llamadas (
    idestllam integer NOT NULL,
    estllamnom character varying(48) NOT NULL
);


ALTER TABLE public.sgc_estatus_llamadas OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 124911)
-- Name: sgc_estatus_llamadas_idestllam_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_estatus_llamadas_idestllam_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_estatus_llamadas_idestllam_seq OWNER TO postgres;

--
-- TOC entry 3304 (class 0 OID 0)
-- Dependencies: 205
-- Name: sgc_estatus_llamadas_idestllam_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_estatus_llamadas_idestllam_seq OWNED BY public.sgc_estatus_llamadas.idestllam;


--
-- TOC entry 206 (class 1259 OID 124913)
-- Name: sgc_migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.sgc_migrations OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 124919)
-- Name: sgc_migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_migrations_id_seq OWNER TO postgres;

--
-- TOC entry 3305 (class 0 OID 0)
-- Dependencies: 207
-- Name: sgc_migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_migrations_id_seq OWNED BY public.sgc_migrations.id;


--
-- TOC entry 208 (class 1259 OID 124921)
-- Name: sgc_municipio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_municipio (
    municipioid integer NOT NULL,
    municipionom character varying(48) NOT NULL,
    estadoid integer NOT NULL
);


ALTER TABLE public.sgc_municipio OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 124924)
-- Name: sgc_municipio_municipioid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_municipio_municipioid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_municipio_municipioid_seq OWNER TO postgres;

--
-- TOC entry 3306 (class 0 OID 0)
-- Dependencies: 209
-- Name: sgc_municipio_municipioid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_municipio_municipioid_seq OWNED BY public.sgc_municipio.municipioid;


--
-- TOC entry 210 (class 1259 OID 124926)
-- Name: sgc_oficinas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_oficinas (
    idofi integer NOT NULL,
    ofinom character varying(48) NOT NULL
);


ALTER TABLE public.sgc_oficinas OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 124929)
-- Name: sgc_oficinas_idofi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_oficinas_idofi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_oficinas_idofi_seq OWNER TO postgres;

--
-- TOC entry 3307 (class 0 OID 0)
-- Dependencies: 211
-- Name: sgc_oficinas_idofi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_oficinas_idofi_seq OWNED BY public.sgc_oficinas.idofi;


--
-- TOC entry 212 (class 1259 OID 124931)
-- Name: sgc_paises; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_paises (
    paisid integer NOT NULL,
    paisnom character varying(48) NOT NULL
);


ALTER TABLE public.sgc_paises OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 124934)
-- Name: sgc_paises_paisid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_paises_paisid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_paises_paisid_seq OWNER TO postgres;

--
-- TOC entry 3308 (class 0 OID 0)
-- Dependencies: 213
-- Name: sgc_paises_paisid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_paises_paisid_seq OWNED BY public.sgc_paises.paisid;


--
-- TOC entry 214 (class 1259 OID 124936)
-- Name: sgc_parroquias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_parroquias (
    parroquiaid integer NOT NULL,
    parroquianom character varying(48) NOT NULL,
    municipioid integer NOT NULL
);


ALTER TABLE public.sgc_parroquias OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 124939)
-- Name: sgc_parroquias_parroquiaid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_parroquias_parroquiaid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_parroquias_parroquiaid_seq OWNER TO postgres;

--
-- TOC entry 3309 (class 0 OID 0)
-- Dependencies: 215
-- Name: sgc_parroquias_parroquiaid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_parroquias_parroquiaid_seq OWNED BY public.sgc_parroquias.parroquiaid;


--
-- TOC entry 216 (class 1259 OID 124941)
-- Name: sgc_red_social; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_red_social (
    red_s_id integer NOT NULL,
    red_s_nom character varying(48) NOT NULL,
    red_s_borrado boolean DEFAULT false
);


ALTER TABLE public.sgc_red_social OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 124944)
-- Name: sgc_red_social_idrrss_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_red_social_idrrss_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_red_social_idrrss_seq OWNER TO postgres;

--
-- TOC entry 3310 (class 0 OID 0)
-- Dependencies: 217
-- Name: sgc_red_social_idrrss_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_red_social_idrrss_seq OWNED BY public.sgc_red_social.red_s_id;


--
-- TOC entry 237 (class 1259 OID 136111)
-- Name: sgc_registro_cgr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_registro_cgr (
    id_cgr integer NOT NULL,
    competencia_cgr integer NOT NULL,
    asume_cgr integer NOT NULL,
    borrado_cgr boolean DEFAULT false NOT NULL,
    id_caso integer
);


ALTER TABLE public.sgc_registro_cgr OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 136109)
-- Name: sgc_registro_cgr_id_cgr_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_registro_cgr_id_cgr_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_registro_cgr_id_cgr_seq OWNER TO postgres;

--
-- TOC entry 3311 (class 0 OID 0)
-- Dependencies: 236
-- Name: sgc_registro_cgr_id_cgr_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_registro_cgr_id_cgr_seq OWNED BY public.sgc_registro_cgr.id_cgr;


--
-- TOC entry 218 (class 1259 OID 124946)
-- Name: sgc_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_roles (
    idrol integer NOT NULL,
    rolnom character varying(48) NOT NULL
);


ALTER TABLE public.sgc_roles OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 124949)
-- Name: sgc_roles_idrol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_roles_idrol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_roles_idrol_seq OWNER TO postgres;

--
-- TOC entry 3312 (class 0 OID 0)
-- Dependencies: 219
-- Name: sgc_roles_idrol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_roles_idrol_seq OWNED BY public.sgc_roles.idrol;


--
-- TOC entry 227 (class 1259 OID 126622)
-- Name: sgc_seguimiento_caso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_seguimiento_caso (
    idsegcas integer NOT NULL,
    idcaso integer NOT NULL,
    idestllam integer NOT NULL,
    segcoment character varying(512) NOT NULL,
    segfec date NOT NULL,
    idusuopr integer NOT NULL,
    borrado boolean DEFAULT false
);


ALTER TABLE public.sgc_seguimiento_caso OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 126620)
-- Name: sgc_seguimiento_caso_idsegcas_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_seguimiento_caso_idsegcas_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_seguimiento_caso_idsegcas_seq OWNER TO postgres;

--
-- TOC entry 3313 (class 0 OID 0)
-- Dependencies: 226
-- Name: sgc_seguimiento_caso_idsegcas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_seguimiento_caso_idsegcas_seq OWNED BY public.sgc_seguimiento_caso.idsegcas;


--
-- TOC entry 231 (class 1259 OID 136039)
-- Name: sgc_tipo_prop_caso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_tipo_prop_caso (
    idtipopropcaso integer NOT NULL,
    idtippropint integer NOT NULL,
    idcaso integer NOT NULL
);


ALTER TABLE public.sgc_tipo_prop_caso OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 136037)
-- Name: sgc_tipo_prop_caso_idtipopropcaso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_tipo_prop_caso_idtipopropcaso_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_tipo_prop_caso_idtipopropcaso_seq OWNER TO postgres;

--
-- TOC entry 3314 (class 0 OID 0)
-- Dependencies: 230
-- Name: sgc_tipo_prop_caso_idtipopropcaso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_tipo_prop_caso_idtipopropcaso_seq OWNED BY public.sgc_tipo_prop_caso.idtipopropcaso;


--
-- TOC entry 220 (class 1259 OID 124964)
-- Name: sgc_tipo_prop_intelec; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_tipo_prop_intelec (
    tipo_prop_id integer NOT NULL,
    tipo_prop_nombre character varying(48) NOT NULL,
    tipo_prop_borrado boolean DEFAULT false
);


ALTER TABLE public.sgc_tipo_prop_intelec OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 124967)
-- Name: sgc_tipo_prop_intelec_idtippropint_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_tipo_prop_intelec_idtippropint_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_tipo_prop_intelec_idtippropint_seq OWNER TO postgres;

--
-- TOC entry 3315 (class 0 OID 0)
-- Dependencies: 221
-- Name: sgc_tipo_prop_intelec_idtippropint_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_tipo_prop_intelec_idtippropint_seq OWNED BY public.sgc_tipo_prop_intelec.tipo_prop_id;


--
-- TOC entry 229 (class 1259 OID 134870)
-- Name: sgc_tipoatencion_usu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_tipoatencion_usu (
    tipo_aten_id integer NOT NULL,
    tipo_aten_nombre text NOT NULL,
    tipo_aten_borrado boolean DEFAULT false NOT NULL
);


ALTER TABLE public.sgc_tipoatencion_usu OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 134868)
-- Name: sgc_tipoatencion_usu_tipo_anten_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_tipoatencion_usu_tipo_anten_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_tipoatencion_usu_tipo_anten_id_seq OWNER TO postgres;

--
-- TOC entry 3316 (class 0 OID 0)
-- Dependencies: 228
-- Name: sgc_tipoatencion_usu_tipo_anten_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_tipoatencion_usu_tipo_anten_id_seq OWNED BY public.sgc_tipoatencion_usu.tipo_aten_id;


--
-- TOC entry 222 (class 1259 OID 124986)
-- Name: sgc_usuario_operador; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sgc_usuario_operador (
    idusuopr integer NOT NULL,
    usuopnom character varying(48) NOT NULL,
    usuopape character varying(48) NOT NULL,
    usuoppass character varying(255) NOT NULL,
    usuopemail character varying(48) NOT NULL,
    idrol integer NOT NULL,
    usuopborrado boolean DEFAULT false,
    usercargo text
);


ALTER TABLE public.sgc_usuario_operador OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 124989)
-- Name: sgc_usuario_operador_idusuopr_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sgc_usuario_operador_idusuopr_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sgc_usuario_operador_idusuopr_seq OWNER TO postgres;

--
-- TOC entry 3317 (class 0 OID 0)
-- Dependencies: 223
-- Name: sgc_usuario_operador_idusuopr_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sgc_usuario_operador_idusuopr_seq OWNED BY public.sgc_usuario_operador.idusuopr;


--
-- TOC entry 3036 (class 2604 OID 136060)
-- Name: sgc_auditoria_sistema audi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_auditoria_sistema ALTER COLUMN audi_id SET DEFAULT nextval('public.sgc_auditoria_sistema_audi_id_seq'::regclass);


--
-- TOC entry 3027 (class 2604 OID 126584)
-- Name: sgc_casos idcaso; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos ALTER COLUMN idcaso SET DEFAULT nextval('public.sgc_casos_idcaso_seq'::regclass);


--
-- TOC entry 3042 (class 2604 OID 136123)
-- Name: sgc_casos_denuncias denu_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos_denuncias ALTER COLUMN denu_id SET DEFAULT nextval('public.sgc_casos_denuncias_denu_id_seq'::regclass);


--
-- TOC entry 3038 (class 2604 OID 136104)
-- Name: sgc_casos_remitidos casos_re_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos_remitidos ALTER COLUMN casos_re_id SET DEFAULT nextval('public.sgc_casos_remitidos_casos_re_id_seq'::regclass);


--
-- TOC entry 3051 (class 2604 OID 136234)
-- Name: sgc_direcciones_administrativas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_direcciones_administrativas ALTER COLUMN id SET DEFAULT nextval('public.sgc_direcciones_administrativas_id_seq'::regclass);


--
-- TOC entry 3048 (class 2604 OID 136172)
-- Name: sgc_documentos_casos docu_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_documentos_casos ALTER COLUMN docu_id SET DEFAULT nextval('public.sgc_documentos_casos_docu_id_seq'::regclass);


--
-- TOC entry 3049 (class 2604 OID 136183)
-- Name: sgc_ente_asdcrito ente_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_ente_asdcrito ALTER COLUMN ente_id SET DEFAULT nextval('public.sgc_ente_asdcrito_ente_id_seq'::regclass);


--
-- TOC entry 3011 (class 2604 OID 124993)
-- Name: sgc_estados estadoid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estados ALTER COLUMN estadoid SET DEFAULT nextval('public.sgc_estados_estadoid_seq'::regclass);


--
-- TOC entry 3013 (class 2604 OID 124994)
-- Name: sgc_estatus idest; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estatus ALTER COLUMN idest SET DEFAULT nextval('public.sgc_estatus_idest_seq'::regclass);


--
-- TOC entry 3014 (class 2604 OID 124995)
-- Name: sgc_estatus_llamadas idestllam; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estatus_llamadas ALTER COLUMN idestllam SET DEFAULT nextval('public.sgc_estatus_llamadas_idestllam_seq'::regclass);


--
-- TOC entry 3015 (class 2604 OID 124996)
-- Name: sgc_migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_migrations ALTER COLUMN id SET DEFAULT nextval('public.sgc_migrations_id_seq'::regclass);


--
-- TOC entry 3016 (class 2604 OID 124997)
-- Name: sgc_municipio municipioid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_municipio ALTER COLUMN municipioid SET DEFAULT nextval('public.sgc_municipio_municipioid_seq'::regclass);


--
-- TOC entry 3017 (class 2604 OID 124998)
-- Name: sgc_oficinas idofi; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_oficinas ALTER COLUMN idofi SET DEFAULT nextval('public.sgc_oficinas_idofi_seq'::regclass);


--
-- TOC entry 3018 (class 2604 OID 124999)
-- Name: sgc_paises paisid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_paises ALTER COLUMN paisid SET DEFAULT nextval('public.sgc_paises_paisid_seq'::regclass);


--
-- TOC entry 3019 (class 2604 OID 125000)
-- Name: sgc_parroquias parroquiaid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_parroquias ALTER COLUMN parroquiaid SET DEFAULT nextval('public.sgc_parroquias_parroquiaid_seq'::regclass);


--
-- TOC entry 3020 (class 2604 OID 125001)
-- Name: sgc_red_social red_s_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_red_social ALTER COLUMN red_s_id SET DEFAULT nextval('public.sgc_red_social_idrrss_seq'::regclass);


--
-- TOC entry 3040 (class 2604 OID 136114)
-- Name: sgc_registro_cgr id_cgr; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_registro_cgr ALTER COLUMN id_cgr SET DEFAULT nextval('public.sgc_registro_cgr_id_cgr_seq'::regclass);


--
-- TOC entry 3022 (class 2604 OID 125002)
-- Name: sgc_roles idrol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_roles ALTER COLUMN idrol SET DEFAULT nextval('public.sgc_roles_idrol_seq'::regclass);


--
-- TOC entry 3031 (class 2604 OID 126625)
-- Name: sgc_seguimiento_caso idsegcas; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_seguimiento_caso ALTER COLUMN idsegcas SET DEFAULT nextval('public.sgc_seguimiento_caso_idsegcas_seq'::regclass);


--
-- TOC entry 3035 (class 2604 OID 136042)
-- Name: sgc_tipo_prop_caso idtipopropcaso; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_caso ALTER COLUMN idtipopropcaso SET DEFAULT nextval('public.sgc_tipo_prop_caso_idtipopropcaso_seq'::regclass);


--
-- TOC entry 3023 (class 2604 OID 125005)
-- Name: sgc_tipo_prop_intelec tipo_prop_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_intelec ALTER COLUMN tipo_prop_id SET DEFAULT nextval('public.sgc_tipo_prop_intelec_idtippropint_seq'::regclass);


--
-- TOC entry 3033 (class 2604 OID 134873)
-- Name: sgc_tipoatencion_usu tipo_aten_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipoatencion_usu ALTER COLUMN tipo_aten_id SET DEFAULT nextval('public.sgc_tipoatencion_usu_tipo_anten_id_seq'::regclass);


--
-- TOC entry 3025 (class 2604 OID 125010)
-- Name: sgc_usuario_operador idusuopr; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_usuario_operador ALTER COLUMN idusuopr SET DEFAULT nextval('public.sgc_usuario_operador_idusuopr_seq'::regclass);




INSERT INTO public.sgc_usuario_operador (idusuopr, usuopnom, usuopape, usuoppass, usuopemail, idrol, usuopborrado, usercargo) VALUES (2, 'ADMIN', 'ADMIN', '$2y$10$DM0tv/U.5EnvvcgDZFASbuGI6yCOngaCzzWpHKTgBvim7W550CMVK', 'freddy.torres@sapi.gob.ve', 1, false, 'SUPERVISOR');


--
-- TOC entry 3318 (class 0 OID 0)
-- Dependencies: 232
-- Name: sgc_auditoria_sistema_audi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_auditoria_sistema_audi_id_seq', 412, true);


--
-- TOC entry 3319 (class 0 OID 0)
-- Dependencies: 238
-- Name: sgc_casos_denuncias_denu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_casos_denuncias_denu_id_seq', 10, true);


--
-- TOC entry 3320 (class 0 OID 0)
-- Dependencies: 224
-- Name: sgc_casos_idcaso_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_casos_idcaso_seq', 186, true);


--
-- TOC entry 3321 (class 0 OID 0)
-- Dependencies: 234
-- Name: sgc_casos_remitidos_casos_re_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_casos_remitidos_casos_re_id_seq', 19, true);


--
-- TOC entry 3322 (class 0 OID 0)
-- Dependencies: 244
-- Name: sgc_direcciones_administrativas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_direcciones_administrativas_id_seq', 20, true);


--
-- TOC entry 3323 (class 0 OID 0)
-- Dependencies: 240
-- Name: sgc_documentos_casos_docu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_documentos_casos_docu_id_seq', 74, true);


--
-- TOC entry 3324 (class 0 OID 0)
-- Dependencies: 242
-- Name: sgc_ente_asdcrito_ente_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_ente_asdcrito_ente_id_seq', 2, true);


--
-- TOC entry 3325 (class 0 OID 0)
-- Dependencies: 201
-- Name: sgc_estados_estadoid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_estados_estadoid_seq', 1, false);


--
-- TOC entry 3326 (class 0 OID 0)
-- Dependencies: 203
-- Name: sgc_estatus_idest_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_estatus_idest_seq', 1, false);


--
-- TOC entry 3327 (class 0 OID 0)
-- Dependencies: 205
-- Name: sgc_estatus_llamadas_idestllam_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_estatus_llamadas_idestllam_seq', 1, false);


--
-- TOC entry 3328 (class 0 OID 0)
-- Dependencies: 207
-- Name: sgc_migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_migrations_id_seq', 17, true);


--
-- TOC entry 3329 (class 0 OID 0)
-- Dependencies: 209
-- Name: sgc_municipio_municipioid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_municipio_municipioid_seq', 1, false);


--
-- TOC entry 3330 (class 0 OID 0)
-- Dependencies: 211
-- Name: sgc_oficinas_idofi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_oficinas_idofi_seq', 1, false);


--
-- TOC entry 3331 (class 0 OID 0)
-- Dependencies: 213
-- Name: sgc_paises_paisid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_paises_paisid_seq', 1, false);


--
-- TOC entry 3332 (class 0 OID 0)
-- Dependencies: 215
-- Name: sgc_parroquias_parroquiaid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_parroquias_parroquiaid_seq', 1, false);


--
-- TOC entry 3333 (class 0 OID 0)
-- Dependencies: 217
-- Name: sgc_red_social_idrrss_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_red_social_idrrss_seq', 2, true);


--
-- TOC entry 3334 (class 0 OID 0)
-- Dependencies: 236
-- Name: sgc_registro_cgr_id_cgr_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_registro_cgr_id_cgr_seq', 22, true);


--
-- TOC entry 3335 (class 0 OID 0)
-- Dependencies: 219
-- Name: sgc_roles_idrol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_roles_idrol_seq', 1, false);


--
-- TOC entry 3336 (class 0 OID 0)
-- Dependencies: 226
-- Name: sgc_seguimiento_caso_idsegcas_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_seguimiento_caso_idsegcas_seq', 35, true);


--
-- TOC entry 3337 (class 0 OID 0)
-- Dependencies: 230
-- Name: sgc_tipo_prop_caso_idtipopropcaso_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_tipo_prop_caso_idtipopropcaso_seq', 79, true);


--
-- TOC entry 3338 (class 0 OID 0)
-- Dependencies: 221
-- Name: sgc_tipo_prop_intelec_idtippropint_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_tipo_prop_intelec_idtippropint_seq', 1, false);


--
-- TOC entry 3339 (class 0 OID 0)
-- Dependencies: 228
-- Name: sgc_tipoatencion_usu_tipo_anten_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_tipoatencion_usu_tipo_anten_id_seq', 21, true);


--
-- TOC entry 3340 (class 0 OID 0)
-- Dependencies: 223
-- Name: sgc_usuario_operador_idusuopr_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sgc_usuario_operador_idusuopr_seq', 14, true);


--
-- TOC entry 3086 (class 2606 OID 136066)
-- Name: sgc_auditoria_sistema auditoria_de_sistema_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_auditoria_sistema
    ADD CONSTRAINT auditoria_de_sistema_pkey PRIMARY KEY (audi_id);


--
-- TOC entry 3078 (class 2606 OID 126589)
-- Name: sgc_casos pk_sgc_casos; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT pk_sgc_casos PRIMARY KEY (idcaso);


--
-- TOC entry 3054 (class 2606 OID 125016)
-- Name: sgc_estados pk_sgc_estados; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estados
    ADD CONSTRAINT pk_sgc_estados PRIMARY KEY (estadoid);


--
-- TOC entry 3056 (class 2606 OID 125018)
-- Name: sgc_estatus pk_sgc_estatus; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estatus
    ADD CONSTRAINT pk_sgc_estatus PRIMARY KEY (idest);


--
-- TOC entry 3058 (class 2606 OID 125020)
-- Name: sgc_estatus_llamadas pk_sgc_estatus_llamadas; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estatus_llamadas
    ADD CONSTRAINT pk_sgc_estatus_llamadas PRIMARY KEY (idestllam);


--
-- TOC entry 3060 (class 2606 OID 125022)
-- Name: sgc_migrations pk_sgc_migrations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_migrations
    ADD CONSTRAINT pk_sgc_migrations PRIMARY KEY (id);


--
-- TOC entry 3062 (class 2606 OID 125024)
-- Name: sgc_municipio pk_sgc_municipio; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_municipio
    ADD CONSTRAINT pk_sgc_municipio PRIMARY KEY (municipioid);


--
-- TOC entry 3064 (class 2606 OID 125026)
-- Name: sgc_oficinas pk_sgc_oficinas; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_oficinas
    ADD CONSTRAINT pk_sgc_oficinas PRIMARY KEY (idofi);


--
-- TOC entry 3066 (class 2606 OID 125028)
-- Name: sgc_paises pk_sgc_paises; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_paises
    ADD CONSTRAINT pk_sgc_paises PRIMARY KEY (paisid);


--
-- TOC entry 3068 (class 2606 OID 125030)
-- Name: sgc_parroquias pk_sgc_parroquias; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_parroquias
    ADD CONSTRAINT pk_sgc_parroquias PRIMARY KEY (parroquiaid);


--
-- TOC entry 3070 (class 2606 OID 125032)
-- Name: sgc_red_social pk_sgc_red_social; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_red_social
    ADD CONSTRAINT pk_sgc_red_social PRIMARY KEY (red_s_id);


--
-- TOC entry 3072 (class 2606 OID 125034)
-- Name: sgc_roles pk_sgc_roles; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_roles
    ADD CONSTRAINT pk_sgc_roles PRIMARY KEY (idrol);


--
-- TOC entry 3080 (class 2606 OID 126630)
-- Name: sgc_seguimiento_caso pk_sgc_seguimiento_caso; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_seguimiento_caso
    ADD CONSTRAINT pk_sgc_seguimiento_caso PRIMARY KEY (idsegcas);


--
-- TOC entry 3084 (class 2606 OID 136044)
-- Name: sgc_tipo_prop_caso pk_sgc_tipo_prop_caso; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_caso
    ADD CONSTRAINT pk_sgc_tipo_prop_caso PRIMARY KEY (idtipopropcaso);


--
-- TOC entry 3074 (class 2606 OID 125040)
-- Name: sgc_tipo_prop_intelec pk_sgc_tipo_prop_intelec; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_intelec
    ADD CONSTRAINT pk_sgc_tipo_prop_intelec PRIMARY KEY (tipo_prop_id);


--
-- TOC entry 3076 (class 2606 OID 125046)
-- Name: sgc_usuario_operador pk_sgc_usuario_operador; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_usuario_operador
    ADD CONSTRAINT pk_sgc_usuario_operador PRIMARY KEY (idusuopr);


--
-- TOC entry 3092 (class 2606 OID 136132)
-- Name: sgc_casos_denuncias sgc_casos_denuncias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos_denuncias
    ADD CONSTRAINT sgc_casos_denuncias_pkey PRIMARY KEY (denu_id);


--
-- TOC entry 3088 (class 2606 OID 136107)
-- Name: sgc_casos_remitidos sgc_casos_remitidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos_remitidos
    ADD CONSTRAINT sgc_casos_remitidos_pkey PRIMARY KEY (casos_re_id);


--
-- TOC entry 3094 (class 2606 OID 136177)
-- Name: sgc_documentos_casos sgc_documentos_casos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_documentos_casos
    ADD CONSTRAINT sgc_documentos_casos_pkey PRIMARY KEY (docu_id);


--
-- TOC entry 3096 (class 2606 OID 136189)
-- Name: sgc_ente_asdcrito sgc_ente_asdcrito_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_ente_asdcrito
    ADD CONSTRAINT sgc_ente_asdcrito_pkey PRIMARY KEY (ente_id);


--
-- TOC entry 3090 (class 2606 OID 136117)
-- Name: sgc_registro_cgr sgc_registro_cgr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_registro_cgr
    ADD CONSTRAINT sgc_registro_cgr_pkey PRIMARY KEY (id_cgr);


--
-- TOC entry 3082 (class 2606 OID 134879)
-- Name: sgc_tipoatencion_usu sgc_tipoatencion_usu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipoatencion_usu
    ADD CONSTRAINT sgc_tipoatencion_usu_pkey PRIMARY KEY (tipo_aten_id);


--
-- TOC entry 3098 (class 2606 OID 136240)
-- Name: sgc_direcciones_administrativas ubicacion_administrativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_direcciones_administrativas
    ADD CONSTRAINT ubicacion_administrativa_pkey PRIMARY KEY (id);


--
-- TOC entry 3103 (class 2606 OID 126590)
-- Name: sgc_casos sgc_casos_estadoid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_estadoid_foreign FOREIGN KEY (estadoid) REFERENCES public.sgc_estados(estadoid);


--
-- TOC entry 3104 (class 2606 OID 126595)
-- Name: sgc_casos sgc_casos_idest_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_idest_foreign FOREIGN KEY (idest) REFERENCES public.sgc_estatus(idest);


--
-- TOC entry 3105 (class 2606 OID 126600)
-- Name: sgc_casos sgc_casos_idrrss_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_idrrss_foreign FOREIGN KEY (idrrss) REFERENCES public.sgc_red_social(red_s_id);


--
-- TOC entry 3106 (class 2606 OID 126605)
-- Name: sgc_casos sgc_casos_idusuopr_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_idusuopr_foreign FOREIGN KEY (idusuopr) REFERENCES public.sgc_usuario_operador(idusuopr);


--
-- TOC entry 3107 (class 2606 OID 126610)
-- Name: sgc_casos sgc_casos_municipioid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_municipioid_foreign FOREIGN KEY (municipioid) REFERENCES public.sgc_municipio(municipioid);


--
-- TOC entry 3108 (class 2606 OID 126615)
-- Name: sgc_casos sgc_casos_parroquiaid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_casos
    ADD CONSTRAINT sgc_casos_parroquiaid_foreign FOREIGN KEY (parroquiaid) REFERENCES public.sgc_parroquias(parroquiaid);


--
-- TOC entry 3099 (class 2606 OID 125077)
-- Name: sgc_estados sgc_estados_paisid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_estados
    ADD CONSTRAINT sgc_estados_paisid_foreign FOREIGN KEY (paisid) REFERENCES public.sgc_paises(paisid);


--
-- TOC entry 3100 (class 2606 OID 125082)
-- Name: sgc_municipio sgc_municipio_estadoid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_municipio
    ADD CONSTRAINT sgc_municipio_estadoid_foreign FOREIGN KEY (estadoid) REFERENCES public.sgc_estados(estadoid);


--
-- TOC entry 3101 (class 2606 OID 125087)
-- Name: sgc_parroquias sgc_parroquias_municipioid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_parroquias
    ADD CONSTRAINT sgc_parroquias_municipioid_foreign FOREIGN KEY (municipioid) REFERENCES public.sgc_municipio(municipioid);


--
-- TOC entry 3109 (class 2606 OID 126631)
-- Name: sgc_seguimiento_caso sgc_seguimiento_caso_idcaso_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_seguimiento_caso
    ADD CONSTRAINT sgc_seguimiento_caso_idcaso_foreign FOREIGN KEY (idcaso) REFERENCES public.sgc_casos(idcaso);


--
-- TOC entry 3110 (class 2606 OID 126636)
-- Name: sgc_seguimiento_caso sgc_seguimiento_caso_idestllam_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_seguimiento_caso
    ADD CONSTRAINT sgc_seguimiento_caso_idestllam_foreign FOREIGN KEY (idestllam) REFERENCES public.sgc_estatus_llamadas(idestllam);


--
-- TOC entry 3111 (class 2606 OID 126641)
-- Name: sgc_seguimiento_caso sgc_seguimiento_caso_idusuopr_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_seguimiento_caso
    ADD CONSTRAINT sgc_seguimiento_caso_idusuopr_foreign FOREIGN KEY (idusuopr) REFERENCES public.sgc_usuario_operador(idusuopr);


--
-- TOC entry 3112 (class 2606 OID 136045)
-- Name: sgc_tipo_prop_caso sgc_tipo_prop_caso_idcaso_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_caso
    ADD CONSTRAINT sgc_tipo_prop_caso_idcaso_foreign FOREIGN KEY (idcaso) REFERENCES public.sgc_casos(idcaso);


--
-- TOC entry 3113 (class 2606 OID 136050)
-- Name: sgc_tipo_prop_caso sgc_tipo_prop_caso_idtippropint_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_tipo_prop_caso
    ADD CONSTRAINT sgc_tipo_prop_caso_idtippropint_foreign FOREIGN KEY (idtippropint) REFERENCES public.sgc_tipo_prop_intelec(tipo_prop_id);


--
-- TOC entry 3102 (class 2606 OID 125117)
-- Name: sgc_usuario_operador sgc_usuario_operador_idrol_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sgc_usuario_operador
    ADD CONSTRAINT sgc_usuario_operador_idrol_foreign FOREIGN KEY (idrol) REFERENCES public.sgc_roles(idrol);


-- Completed on 2023-10-23 15:18:30 -04

--
-- PostgreSQL database dump complete
--

