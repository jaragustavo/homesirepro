<?php
    /* TODO: Inicio de Session */
    session_start();
    class Conectar{
        protected $dbh;

     /*   protected function Conexion(){
            try{
                  $conectar = $this->dbh=new PDO("sqlsrv:Server=localhost;Database=CompraVenta","sa","andersonxx");
                //$conectar = $this->dbh=new PDO("sqlsrv:server = tcp:andercode01.database.windows.net,1433; Database = compraventa01","andercode","Anderson1987");
                return $conectar;
            }catch (Exception $e){
                 print "Error Conexion BD". $e->getMessage() ."<br/>";
                die();
            }
        }
*/
        protected function Conexion(){

			$contraseña = "postgres";
			$usuario = "postgres";
			$nombreBaseDeDatos = "sirepro_db";
			# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
			// $rutaServidor = " 127.0.0.1";
	        $rutaServidor = "localhost";
		//	$rutaServidor = "147.182.138.250";
			$puerto = "5432";

			try {

			//	$base_de_datos = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos;options='--client_encoding=SQL_ASCII'", $usuario, $contraseña);
		
            $conectar = $this->dbh= new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña, 
						 array(PDO::ATTR_PERSISTENT => true));

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
			# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
			// $rutaServidor = " 127.0.0.1";
	        $rutaServidor = "159.65.242.229";
		//	$rutaServidor = "147.182.138.250";
			$puerto = "5432";

			try {

			//	$base_de_datos = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos;options='--client_encoding=SQL_ASCII'", $usuario, $contraseña);
		
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
            return "http://localhost:90/homesirepro/";
            /* return "https://compraventaandercode.azurewebsites.net/"; */
        }
    }
?>