<?php
	require_once("CBBDD.php");
	
	class CSitioWeb extends CBBDD{

		// Definimos atributos
		//https://phpdelusions.net/pdo_examples/connect_to_mysql

		public $idsitioweb;
		public $nombre;		
		public $url;

	    function __construct() {
	    	parent::__construct();
	    	//$this->conn = parent::conn;
			$this->idsitioweb="";
			$this->nombre="";
			$this->url="";	    	
	    }	        
	    // Obtiene los datos de un determinado sitio web    
		public function ObtenerDatos($idsitioweb){
			try {
				$sql="select * from sitiosweb where idsitioweb='$idsitioweb'";
				if ($this->CS($sql)) {
					if ($fila=$this->mDatos->fetch_assoc()) { 	
						//Login correcto, obtenemos el código y nombre:
						$this->nombre=$fila["nombre"];
						$this->url=$fila["url"];
					}
					$this->mDatos->close();
				}
			} catch (Error $e) {
				throw $e;
			}					
		}
		
		//Inserta un nuevo sitio web, devuelve su nuevo id si ok, -1 si no lo consigue: 
		public function insertar($nombre, $url) {
			try {
				//Insertamos la nueva categoria
				$sql = "insert into sitiosweb (	
							nombre,
							url
							) 
						values 
							(
							'$nombre',
							'$url'		
							)";				

				$id = $this->CE($sql,true);
				if ($id>0) {
					$this->nombre=$nombre;
					$this->url=$url;
					$this->idsitioweb=$id;
				}
			}catch (Error $e) {
				throw $e;
			}
		}
		//Actualiza un sitio web, devuelve el número de filas afectadas para saber si se ha actualizado o no:
		public function actualizar( $idsitioweb, $nombre, $url) {
			$res = 0;

			try {
				$sql="update sitiosweb set nombre='$nombre', url ='$url'
				 	where idsitioweb='$idsitioweb'";
				$res = $this->CE($sql,false);
				if ($res<=0) {
					throw new Exception("No se han podido modificar los datos");
				}else{
					$this->nombre=$nombre;
					$this->url=$url;	
				}		 
			} catch (Error $e) {
				throw $e;
			}
			return $res;
		}	

		//Elimina un sitio web, devuelve su nuevo id si ok, -1 si no lo consigue: 
		public function Eliminar($idsitioweb) {
			$total = 0;
			try {
				$sql="delete from sitiosweb where idsitioweb='$idsitioweb'";
				$total = $this->CE($sql);
				if ($total<=0) {
					throw new Exception("No se ha podido eliminar el registro");
				}else{
					$this->nombre="";
					$this->foto="";	
				}					
			}catch (Error $e) {
				throw $e;
			}
			return $total;
		}

		//Devuelve la lista de sitios web según la condición
		public function catalogo() {
			$lista=array();
			try {
				$sql="select * from sitiosweb order by nombre";
				if ($this->CS($sql)) {
					$i=0;
					while ($fila=$this->mDatos->fetch_assoc()){
						array_push($lista,$fila);
					}
					$this->mDatos->close();
				}
			} catch (Error $e) {
				throw new Exception($sql);
			}
			return $lista;
		}				
	}
?>