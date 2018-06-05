<?php
namespace App\Model;

use App\Lib\Response;

class ReporteModel
{
    private $db;
    private $response;
    
    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function topEmpleado()
    {
//        SELECT
//            e.Imagen,
//            e.Nombre,
//            COUNT(p.id) Pedidos
//        FROM empleado e
//        LEFT JOIN pedido p
//        ON e.id =  p.Empleado_id
//        AND p.Estado_id = 1
//        GROUP BY e.id
//        ORDER BY Pedidos DESC
                
        return $this->db->from("empleado e")
                        ->select('e.Imagen, e.Nombre, COUNT(p.id) Pedidos')
                        ->leftJoin('pedido p ON e.id =  p.Empleado_id AND p.Estado_id = 1')
                        ->orderBy('Pedidos DESC')
                        ->groupBy('e.id')
                        ->fetchAll();
    }
    
    public function topProducto()
    {
//SELECT
//	pr.Imagen,
//	pr.Nombre,
//	IFNULL(SUM(pd.Cantidad), 0) Cantidad,
//	IFNULL(SUM(pd.Total), 0) Total
//FROM producto pr
//LEFT JOIN pedido_detalle pd
//ON pr.id = pd.Producto_id
//LEFT JOIN pedido p
//ON p.id = pd.Pedido_id
//AND p.Estado_id = 1
//GROUP BY pr.id
//ORDER BY Cantidad DESC, Total DESC
        
        return $this->db->from("producto pr")
                        ->select('pr.Imagen, pr.Nombre, IFNULL(SUM(pd.Cantidad), 0) Cantidad, IFNULL(SUM(pd.Total), 0) Total')
                        ->leftJoin('pedido_detalle pd ON pr.id = pd.Producto_id')
                        ->leftJoin('pedido p ON p.id = pd.Pedido_id AND p.Estado_id = 1')
                        ->orderBy('Cantidad DESC, Total DESC')
                        ->groupBy('pr.id')
                        ->fetchAll();
    }
    
    public function ventaMensual()
    {
//SELECT
//	CONCAT(YEAR(p.Fecha), ', ', MONTH(p.Fecha)) Periodo,
//	SUM(p.Total) Total
//FROM pedido p
//GROUP BY YEAR(p.Fecha), MONTH(p.Fecha)
//ORDER BY Periodo DESC

        return $this->db->from("pedido p")
                        ->select("CONCAT(YEAR(p.Fecha), ', ', MONTH(p.Fecha)) Periodo, SUM(p.Total) Total")
                        ->where('p.Estado_id = 1')
                        ->orderBy('Periodo DESC')
                        ->groupBy('YEAR(p.Fecha), MONTH(p.Fecha)')
                        ->fetchAll();
    }
}