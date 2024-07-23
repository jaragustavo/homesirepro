<?php
    session_start();

	define('TOKEN_SECRETO', 'alguno'); // Usa el token generado

    class Conectar{
        static public function Conexion(){
			$contraseña = "dgt1c.123**";
			$usuario = "postgres";
			$nombreBaseDeDatos = "homesirepro";
	        $rutaServidor = "localhost";
			$puerto = "5432";
			
			// $contraseña = "postgres";
			// $usuario = "postgres";
			// $nombreBaseDeDatos = "homesirepro";
	        // $rutaServidor = "localhost";
			// $puerto = "5432";

			try {
           $dbh= new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña, 
						 array(PDO::ATTR_PERSISTENT => true));
						 $conectar =$dbh;
			$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			} catch (Exception $e) {

				echo "Ocurrió un error con la base de datos: " . $e->getMessage();
			}
			return $conectar;
		
	    }

        protected function ConexionSirepro(){
			//$cnxString = "host='127.0.0.1' port='5432' dbname='sirepro' user='usuario_sirepro' password=':-)PassSirepro001122'";
			$contraseña = ":-)PassSirepro001122";
			$usuario = "usuario_sirepro";
			$nombreBaseDeDatos = "sirepro";
	        $rutaServidor = "192.168.1.66";
			$puerto = "5432";

			try {
            $conectar = $this->dbh= new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña, 
						 array(PDO::ATTR_PERSISTENT => true));

			$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			} catch (Exception $e) {

				echo "Ocurrió un error con la base de datos: " . $e->getMessage();
			}
			return $conectar;
		
	    }

        public static function ruta(){
			/* TODO: Ruta de acceso del Proyecto (Validar su puerto y nombre de carpeta por el suyo) */
           // return "http://localhost:90/homesirepro/";
			// return "http://localhost/MSPBS_SISTEMA/homesirepro/";
			 return "https://homesirepro.mspbs.gov.py/homesirepro/";
        }
    }
?>