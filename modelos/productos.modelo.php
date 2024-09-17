<?php

require_once "conexion.php";

class ProductosModelo{

    static public function mdlGetListarProductosTable($domain){
        $where = '';
        if(count($domain) === 1){
            $where = "WHERE ".$domain[0]->campo1." ".$domain[0]->validacion." ".$domain[0]->campo2;
        }
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            p.id_producto,
            p.id_categoria,
            p.id_udm,
            p.id_udm_compra,
            p.id_talla,
            p.id_color,
            p.id_marca,
            p.precio,
            p.costo,
            p.nombre,
            CONCAT(
                IF(p.nombre IS NOT NULL AND p.nombre != '',
                    CONCAT(p.nombre,
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            '(',
                        ''),
                        IF(m.nombre IS NOT NULL AND m.nombre != '',
                            CONCAT(m.nombre,
                                IF((t.nombre IS NOT NULL AND t.nombre != '') OR
                                    (c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(t.nombre IS NOT NULL AND t.nombre != '',
                            CONCAT(t.nombre,
                                IF((c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(c.nombre IS NOT NULL AND c.nombre != '',
                            c.nombre,
                        ''),
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            ')',
                        '')
                    ),
                '')
            ) AS nombre_concat,
            IFNULL(m.nombre,'') AS marca,
            p.codigo_barras,
            IFNULL(t.nombre,'') AS talla,
            IFNULL(c.nombre,'') AS color,
            CONCAT('$',FORMAT(p.precio,2)) AS precio_concat,
            CONCAT('$',FORMAT(p.costo,2)) AS costo_concat,
            (WITH RECURSIVE subcategorias AS (
                SELECT id_categoria,id_categoria_padre,nombre
                FROM categorias
                WHERE id_categoria_padre = 0  -- Categorías principales
            UNION ALL
                SELECT c.id_categoria,c.id_categoria_padre,CONCAT(sc.nombre, ' -> ',c.nombre)
                FROM categorias c
                JOIN subcategorias sc ON sc.id_categoria=c.id_categoria_padre
            )
            SELECT nombre FROM subcategorias
            WHERE id_categoria=ca.id_categoria
            LIMIT 1
            ) AS categoria,
            p.stock,
            CONCAT(
                IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                    CONCAT(
                        um.nombre,
                        ' de ',
                        um.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=um.id_udm_referencia)
                    ),
                IFNULL(um.nombre,''))
            ) AS udm,
            p.utilidad,
            p.min_stock,
            CONCAT(
                IF(umc.id_udm_referencia IS NOT NULL AND umc.id_udm_referencia != '',
                    CONCAT(
                        umc.nombre,
                        ' de ',
                        umc.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=umc.id_udm_referencia)
                    ),
                IFNULL(umc.nombre,''))
            ) AS udm_compra,
            p.img_principal,
            p.qr_base64,
            '' AS opciones
        FROM productos p
        LEFT JOIN categorias ca ON ca.id_categoria=p.id_categoria
        LEFT JOIN unidades_medida um ON um.id_unidad_medida=p.id_udm
        LEFT JOIN unidades_medida umc ON umc.id_unidad_medida=p.id_udm_compra
        LEFT JOIN tallas t ON t.id_talla=p.id_talla
        LEFT JOIN colores c ON c.id_color=p.id_color
        LEFT JOIN marcas m ON m.id_marca=p.id_marca
        ".$where."
        ORDER BY p.id_producto");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarProducto($table, $data){
        $objeto = new stdClass();
        try{
            $id_max_producto = self::mdlGetMaxProductoId()->max_id;
            $campos = implode(",", array_keys($data));
            $valores = implode(",", array_values($data));
            $stmt = Conexion::conectar()->prepare("INSERT INTO $table ($campos) VALUES ($valores)");
            if($stmt->execute()){
                $objeto->estado = true;
                $objeto->mensaje = 'El producto se registró correctamente';
                $objeto->datos = '';
            }
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error al hacer el registro';
            $objeto->error = $e->getMessage();
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlSetActualizarInformacion($table, $data, $id, $nameId){
        $objeto = new stdClass();
        try{
            $set = '';
            foreach ($data as $key => $value){
                $set.= $key.' = :'.$key.',';
            }
            $set = substr($set, 0, -1);
            $stmt = Conexion::conectar()->prepare("UPDATE $table SET $set WHERE $nameId = :$nameId");
            foreach ($data as $key => $value) {
                if($data[$key] === 'null'){
                    $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_NULL);
                } else {
                    $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_STR);
                }
            }
            $stmt->bindParam(':'. $nameId, $id, PDO::PARAM_INT);
            if($stmt->execute()){
                $objeto->estado = true;
                $objeto->mensaje = 'Se actualizo correctamente';
                $objeto->datos = '';
            }
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error al hacer la actualizacion';
            $objeto->error = $e->getMessage();
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlSetEliminarInformacion($table, $id, $nameId){
        $objeto = new stdClass();
        try{
            $stmt = Conexion::conectar()->prepare("DELETE FROM $table WHERE $nameId = :$nameId");
            $stmt->bindParam(':'. $nameId, $id, PDO::PARAM_INT);
            if($stmt->execute()){
                $objeto->estado = true;
                $objeto->mensaje = 'Se elimino correctamente';
                $objeto->datos = '';
            }
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error de BD';
            $objeto->error = $e->getMessage();
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlGetMaxProductoId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(p.id_producto),0) + 1 AS max_id
            FROM productos p");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarDatasFieldsTypeSelections(){
        $stmt = Conexion::conectar()->prepare("SELECT *
        FROM(
            WITH RECURSIVE subcategorias AS (
                   SELECT id_categoria,id_categoria_padre,nombre
                   FROM categorias
                   WHERE id_categoria_padre = 0  -- Categorías principales
               UNION ALL
                   SELECT c.id_categoria,c.id_categoria_padre,CONCAT(sc.nombre, ' -> ',c.nombre)
                   FROM categorias c
                   JOIN subcategorias sc ON sc.id_categoria=c.id_categoria_padre
            )
            SELECT ca.id_categoria AS id_registro,ca.nombre,'categorias'AS tabla
            FROM subcategorias AS ca
            WHERE ca.id_categoria NOT IN (
                SELECT id_categoria_padre
                FROM subcategorias
                WHERE id_categoria_padre > 0
            )
            UNION ALL
            SELECT um.id_unidad_medida,
            CONCAT(
                    IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                        CONCAT(
                            um.nombre,
                            ' de ',
                            um.ratio,
                            ' ',
                            um_ref.nombre
                        ),
                    um.nombre)
                ) AS nombre,
                'unidades_medida'
            FROM unidades_medida um
            LEFT JOIN unidades_medida um_ref ON um_ref.id_unidad_medida=um.id_udm_referencia
            UNION ALL
            SELECT ma.id_marca,ma.nombre,'marcas'
            FROM marcas ma
            UNION ALL
            SELECT ta.id_talla,ta.nombre,'tallas'
            FROM tallas ta
            UNION ALL
            SELECT co.id_color,co.nombre,'colores'
            FROM colores co
        ) AS subconsulta
        ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetListaProductosAutocomplete(){
        $stmt = Conexion::conectar()->prepare(" SELECT p.id_producto AS id_producto,
            p.codigo_barras AS codigo_producto,
            CONCAT(
                IF(p.codigo_barras IS NOT NULL AND p.codigo_barras != '',
                    CONCAT(p.codigo_barras,' - '),
                    ''
                ),
                CONCAT(
                IF(p.nombre IS NOT NULL AND p.nombre != '',
                    CONCAT(p.nombre,
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            '(',
                        ''),
                        IF(m.nombre IS NOT NULL AND m.nombre != '',
                            CONCAT(m.nombre,
                                IF((t.nombre IS NOT NULL AND t.nombre != '') OR
                                    (c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(t.nombre IS NOT NULL AND t.nombre != '',
                            CONCAT(t.nombre,
                                IF((c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(c.nombre IS NOT NULL AND c.nombre != '',
                            c.nombre,
                        ''),
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            ')',
                        ''),
                    ' - '),
                'Sin nombre de producto - ')
                ),
                CONCAT('Precio $',FORMAT(p.precio,2)),
                CONCAT(' - Stock:',p.stock),
                CONCAT(
                    IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                        CONCAT(
                            ' ',
                            um.nombre,
                            ' de ',
                            um.ratio,
                            ' ',
                            (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=um.id_udm_referencia)
                        ),
                    IFNULL(CONCAT(' ',um.nombre),''))
                )
            ) AS descripcion_producto,
            CONCAT(
                IF(p.codigo_barras IS NOT NULL AND p.codigo_barras != '',
                    CONCAT(p.codigo_barras,' - '),
                    ''
                ),
                CONCAT(
                IF(p.nombre IS NOT NULL AND p.nombre != '',
                    CONCAT(p.nombre,
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            '(',
                        ''),
                        IF(m.nombre IS NOT NULL AND m.nombre != '',
                            CONCAT(m.nombre,
                                IF((t.nombre IS NOT NULL AND t.nombre != '') OR
                                    (c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(t.nombre IS NOT NULL AND t.nombre != '',
                            CONCAT(t.nombre,
                                IF((c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(c.nombre IS NOT NULL AND c.nombre != '',
                            c.nombre,
                        ''),
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            ')',
                        ''),
                    ' - '),
                'Sin nombre de producto - ')
                ),
                CONCAT('Costo $',FORMAT(p.costo,2)),
                CONCAT(' - Stock:',p.stock),
                CONCAT(
                    IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                        CONCAT(
                            ' ',
                            um.nombre,
                            ' de ',
                            um.ratio,
                            ' ',
                            (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=um.id_udm_referencia)
                        ),
                    IFNULL(CONCAT(' ',um.nombre),''))
                )
            ) AS descripcion_producto_compra
        FROM productos p
        LEFT JOIN unidades_medida um ON um.id_unidad_medida=p.id_udm
        LEFT JOIN categorias ca ON ca.id_categoria=p.id_categoria
        LEFT JOIN tallas t ON t.id_talla=p.id_talla
        LEFT JOIN colores c ON c.id_color=p.id_color
        LEFT JOIN marcas m ON m.id_marca=p.id_marca");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetListarProductosPdV(){
        $stmt = Conexion::conectar()->prepare("SELECT
            p.id_producto,
            p.id_categoria,
            p.id_udm,
            um.ratio AS udm_ratio,
            p.id_udm_compra,
            umc.ratio AS udm_ratio_compra,
            p.id_talla,
            p.id_color,
            p.id_marca,
            CONCAT(
                IF(p.nombre IS NOT NULL AND p.nombre != '',
                    CONCAT(p.nombre,
                        IF((ma.nombre IS NOT NULL AND ma.nombre != '') OR
                            (ta.nombre IS NOT NULL AND ta.nombre != '') OR
                            (co.nombre IS NOT NULL AND co.nombre != ''),
                            '(',
                        ''),
                        IF(ma.nombre IS NOT NULL AND ma.nombre != '',
                            CONCAT(ma.nombre,
                                IF((ta.nombre IS NOT NULL AND ta.nombre != '') OR
                                    (co.nombre IS NOT NULL AND co.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(ta.nombre IS NOT NULL AND ta.nombre != '',
                            CONCAT(ta.nombre,
                                IF((co.nombre IS NOT NULL AND co.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(co.nombre IS NOT NULL AND co.nombre != '',
                            co.nombre,
                        ''),
                        IF((ma.nombre IS NOT NULL AND ma.nombre != '') OR
                            (ta.nombre IS NOT NULL AND ta.nombre != '') OR
                            (co.nombre IS NOT NULL AND co.nombre != ''),
                            ')',
                        '')
                    ),
                'Sin nombre de producto')
            ) AS descripcion_producto,
            IFNULL(ca.nombre,'') AS categoria,
            CONCAT(
                IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                    CONCAT(
                        um.nombre,
                        ' de ',
                        um.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=um.id_udm_referencia)
                    ),
                IFNULL(um.nombre,''))
            ) AS udm,
            CONCAT(
                IF(umc.id_udm_referencia IS NOT NULL AND umc.id_udm_referencia != '',
                    CONCAT(
                        umc.nombre,
                        ' de ',
                        umc.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=umc.id_udm_referencia)
                    ),
                IFNULL(umc.nombre,''))
            ) AS udm_compra,
            IFNULL(ta.nombre,'') AS talla,
            IFNULL(co.nombre,'') AS color,
            IFNULL(ma.nombre,'') AS marca,
            p.precio,
            p.costo,
            p.utilidad,
            p.stock,
            p.min_stock,
            p.codigo_barras,
            p.img_principal,
            p.qr_base64
        FROM productos p
        LEFT JOIN categorias ca ON ca.id_categoria=p.id_categoria
        LEFT JOIN unidades_medida um ON um.id_unidad_medida=p.id_udm
        LEFT JOIN unidades_medida umc ON umc.id_unidad_medida=p.id_udm_compra
        LEFT JOIN tallas ta ON ta.id_talla=p.id_talla
        LEFT JOIN colores co ON co.id_color=p.id_color
        LEFT JOIN marcas ma ON ma.id_marca=p.id_marca");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}