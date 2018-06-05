<?php
namespace App\Model;

use App\Lib\Response,
    App\Lib\Auth;

class AuthModel
{
    private $db;
    private $table = 'usuario';
    private $response;
    
    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function autenticar($correo, $password) {
        $empleado = $this->db->from($this->table)
                             ->where('email', $correo)
                             ->where('password', md5($password))
                             ->fetch();
        
        if(is_object($empleado)){
            $nombre = $empleado->primer_nombre;
            $apellido =$empleado->primer_apellido;
            $token = Auth::SignIn([
                'id' => $empleado->id,
                'Nombre' => $empleado->primer_nombre,
                'NombreCompleto' => $nombre.' '.$apellido,
                //'Imagen' => $empleado->Imagen, LO DEJAMOS COMENTADO PORQUE HACE GENERAR UN TOKEN DEMASIADO GRANDE
                'EsAdmin' => (bool)$empleado->idRol
            ]);
            
            $this->response->result = $token;
            
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false, "Credenciales no válidas");
        }
    }
}