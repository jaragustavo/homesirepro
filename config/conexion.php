<?php
    session_start();
	
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

			$contraseña = "nicoHermann2003....";
			$usuario = "postgres";
			$nombreBaseDeDatos = "sirepro";
	        $rutaServidor = "159.65.242.229";
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