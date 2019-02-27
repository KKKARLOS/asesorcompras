<?php
	require_once("CBBDD.php");
	
	class CCategoria extends CBBDD{

		// Definimos atributos
		//https://phpdelusions.net/pdo_examples/connect_to_mysql

		public $idcategoria;
		public $nombre;		
		public $foto;

	    function __construct() {
	    	parent::__construct();
	    	//$this->conn = parent::conn;
			$this->idcategoria="";
			$this->nombre="";
			$this->foto="";	    	
	    }	        

		public function ObtenerDatos($idcategoria){
			try {
				$sql="select * from categorias where idcategoria='$idcategoria'";
				if ($this->CS($sql)) {
					if ($fila=$this->mDatos->fetch_assoc()) { 	
						//Login correcto, obtenemos el código y nombre:
						$this->nombre=$fila["nombre"];
						$this->foto=$fila["foto"];
					}
					$this->mDatos->close();
				}
			} catch (Error $e) {
				throw $e;
			}					
		}
		
		//Inserta una nueva categoria, devuelve su nuevo id si ok, -1 si no lo consigue: 
		public function insertar($nombre, $foto) {
			try {
				//Insertamos la nueva categoria
				$sql = "insert into categorias (	
							nombre,
							foto
							) 
						values 
							(
							'$nombre',
							'$foto'		
							)";				

				$id = $this->CE($sql,true);
				if ($id>0) {
					$this->nombre=$nombre;
					$this->foto=$foto;
					$this->idcategoria=$id;
				}
			}catch (Error $e) {
				throw $e;
			}
		}
		//Actualiza una categoria, devuelve el número de filas afectadas para saber si se ha actualizado o no:
		public function actualizar( $idcategoria, $nombre, $foto) {
			$res = 0;

			try {
				$sql="update categorias set ";
				if ($foto!="") 
					$sql.="foto = '$foto',";
				$sql.=" nombre='$nombre' 
				 	where idcategoria='$idcategoria'";
				$res = $this->CE($sql,false);
				if ($res<=0) {
					throw new Exception("No se han podido modificar los datos");
				}else{
					$this->nombre=$nombre;
					$this->foto=$foto;	
				}		 
			} catch (Error $e) {
				throw $e;
			}
			return $res;
		}	

		//Elimina una categoria, devuelve su nuevo id si ok, -1 si no lo consigue: 
		public function Eliminar($idcategoria) {
			$total = 0;
			try {
				$sql="delete from categorias where idcategoria='$idcategoria'";
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

		//Devuelve la lista de categorias según la condición
		public function catalogo() {
			$lista=array();
			try {
				$sql="select * from categorias order by nombre";
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