<?php 

    //CONSTANTES DE CONFIGURACIÓN
    define("NIVEL_LOG", 4); //1 Críticos | 2 Críticos + Errores | 3 Críticos + Errores + Debug | 4 Críticos + Errores + Debug + Info
    define("AVISO_EMAIL", false); //false Sin aviso | true Con aviso

    //CONFIGURACIÓN SMTP
    define("SMTP_HOST", "host");
    define("SMTP_USER", "user");
    define("SMTP_PASS", "pass");
    define("SMTP_PORT", 587);

    define("SMTP_MAIL_REMITENTE", "remitente");
    define("SMTP_MAIL_RECEPTOR", "receptor");

?>
