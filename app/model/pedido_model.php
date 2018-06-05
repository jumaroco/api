<?php
namespace App\Model;

use App\Lib\Response;

class PedidoModel
{
    private $db;
    private $table = 'pedido';
    private $response;
    
    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function listar($l, $p)
    {
        $data = $this->db->from($this->table)
                         ->innerJoin("tabla_de_tablas tt ON relacion = 'pedido_estado' AND tt.id = pedido.Estado_id")
                         ->select('pedido.*, empleado.Nombre Empleado, tt.Valor Estado')
                         ->limit($l)
                         ->offset($p)
                         ->orderBy('id DESC')
                         ->fetchAll();
        
        $total = $this->db->from($this->table)
                          ->select('COUNT(*) Total')
                          ->fetch()
                          ->Total;
        
        return [
            'data'  => $data,
            'total' => $total
        ];
    }
    
    public function obtener($id)
    {
        // Cabecera del pedido
        $row = $this->db->from($this->table, $id)
                        ->innerJoin("tabla_de_tablas tt ON relacion = 'pedido_estado' AND tt.id = pedido.Estado_id")
                        ->select('pedido.*, empleado.Nombre Empleado, tt.Valor Estado')
                        ->fetch();
        
        $row->{'Detalle'} = $this->db->from('pedido_detalle')
                                     ->select('pedido_detalle.*, producto.Nombre Producto')
                                     ->where('pedido_id', $id)
                                     ->fetchAll();
        
        return $row;
    }
}