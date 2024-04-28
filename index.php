<?php

    /* 
        Autor: Carlos Ponce
        Contacto: carlosponcemartinez.trabajo@gmail.com
        Versión: 1.0

    */

    require(dirname(__FILE__) . "/vendor/autoload.php");
    require_once(dirname(__FILE__) . "/config.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Log{

        protected $logs = [];

        public function __construct() { }

        private function formatLog($log, $type){
            return date("[d/m/Y h:m:s]") . " - [" . $type . "] - " . $log;
        }

        public function addLog($log, $type = 0){
            switch($type){
                case 0:
                    if(NIVEL_LOG >= 1){array_push($this->logs, $this->formatLog($log, "CRITICAL"));}
                    break;

                case 1:
                    if(NIVEL_LOG >= 2){array_push($this->logs, $this->formatLog($log, "ERROR"));}
                    break;

                case 2:
                    if(NIVEL_LOG >= 3){array_push($this->logs, $this->formatLog($log, "DEBUG"));}
                    break;    
            
                case 3:
                    if(NIVEL_LOG >= 4){array_push($this->logs, $this->formatLog($log, "INFO"));}
                    break; 
            }
        }

        public function getLog(){
            if(AVISO_EMAIL){
                $this->avisoEmail();
            }
            $this->registrarLog();
            return $this->logs;
        }

        private function registrarLog() {
            $rutaLog = dirname(__FILE__) . "/../data/log/" . date("Y") . "/" . date("m M") . "/";
            if (!file_exists($rutaLog)) {
                mkdir($rutaLog, 0777, true);
            }
            $rutaLog .= date("Ymd") . ".log";
            foreach($this->logs as $messageLog){
                file_put_contents($rutaLog, $messageLog . PHP_EOL, FILE_APPEND);
            }
        }

        private function avisoEmail(){

            $emailHandler = new PHPMailer();
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = SMTP_PORT;

            $mail->setFrom(SMTP_MAIL_REMITENTE);
            $mail->addAddress(SMTP_MAIL_RECEPTOR);
            $mail->Subject = 'Error Web';
            $aux = "";
            foreach($this->logs as $log){
                $aux .= $log . "\n";
            }
            $mail->Body    = $aux;

            if($mail->send()){

            }else{
                throw new Exception("No se pudo enviar el email");
            }


        }
        
    }

    /*
        EJEMPLO DE USO
        -------------------------------------------------
        $log = new Log();

        $log->addLog("Esto es un error de log", 0);
        $log->addLog("Esto es un error de log", 1);
        $log->addLog("Esto es un error de log", 2);
        $log->addLog("Esto es un error de log", 3);

        $respuesta = $log->getLog();
        -------------------------------------------------
    */
    
?>