<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Sumar stock al crear compra
        DB::unprepared('
            CREATE TRIGGER sumar_stock_al_crear_compra
            AFTER INSERT ON COMPRA
            WHEN NEW.ESTADO = 1
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD + (
                    SELECT CANTIDAD FROM DETALLE_COMPRA
                    WHERE DETALLE_COMPRA.PRODUCTO = PRODUCTO.ID
                    AND DETALLE_COMPRA.COMPRA = NEW.ID
                )
                WHERE ID IN (
                    SELECT PRODUCTO FROM DETALLE_COMPRA WHERE COMPRA = NEW.ID
                );
            END;
        ');

        // Devolver stock al anular compra
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_anular_compra
            AFTER UPDATE OF ESTADO ON COMPRA
            WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD - (
                    SELECT CANTIDAD FROM DETALLE_COMPRA
                    WHERE DETALLE_COMPRA.PRODUCTO = PRODUCTO.ID
                    AND DETALLE_COMPRA.COMPRA = NEW.ID
                )
                WHERE ID IN (
                    SELECT PRODUCTO FROM DETALLE_COMPRA WHERE COMPRA = NEW.ID
                );
            END;
        ');

        // Restar stock al vender
        DB::unprepared('
            CREATE TRIGGER restar_stock_al_vender
            AFTER INSERT ON DETALLE_VENTA
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD - NEW.CANTIDAD
                WHERE ID = NEW.PRODUCTO
                  AND EXISTS (
                    SELECT 1 FROM VENTA WHERE ID = NEW.VENTA AND ESTADO = 1
                  );
            END;
        ');

        // Devolver stock al anular venta
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_anular_venta
            AFTER UPDATE OF ESTADO ON VENTA
            WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD + (
                    SELECT CANTIDAD FROM DETALLE_VENTA
                    WHERE PRODUCTO = PRODUCTO.ID
                    AND VENTA = NEW.ID
                )
                WHERE ID IN (
                    SELECT PRODUCTO FROM DETALLE_VENTA WHERE VENTA = NEW.ID
                );
            END;
        ');

        // Restar stock al agregar al carrito
        DB::unprepared('
            CREATE TRIGGER restar_stock_al_agregar_carrito
            AFTER INSERT ON DETALLE_CARRITO
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD - NEW.CANTIDAD
                WHERE ID = NEW.PRODUCTO
                  AND EXISTS (
                    SELECT 1 FROM CARRITO WHERE ID = NEW.CARRITO AND ESTADO = 1
                  );
            END;
        ');

        // Devolver stock al cancelar carrito
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_cancelar_carrito
            AFTER UPDATE OF ESTADO ON CARRITO
            WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD + (
                    SELECT CANTIDAD FROM DETALLE_CARRITO
                    WHERE PRODUCTO = PRODUCTO.ID
                    AND CARRITO = NEW.ID
                )
                WHERE ID IN (
                    SELECT PRODUCTO FROM DETALLE_CARRITO WHERE CARRITO = NEW.ID
                );
            END;
        ');

        DB::unprepared('
CREATE TRIGGER actualizar_caja_al_insertar_venta
AFTER INSERT ON VENTA
FOR EACH ROW
BEGIN
    UPDATE CAJA
    SET 
        DIFERENCIA = IFNULL(DIFERENCIA, 0) + NEW.TOTAL,
        CIERRE = IFNULL(CIERRE, 0) + NEW.TOTAL
    WHERE ID = NEW.CAJA;
END;
');

        DB::unprepared('
CREATE TRIGGER actualizar_caja_al_cancelar_venta
AFTER UPDATE ON VENTA
FOR EACH ROW
WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
BEGIN
    UPDATE CAJA
    SET 
        DIFERENCIA = IFNULL(DIFERENCIA, 0) - OLD.TOTAL,
        CIERRE = IFNULL(CIERRE, 0) - OLD.TOTAL
    WHERE ID = OLD.CAJA;
END;
');


    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS sumar_stock_al_crear_compra;');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_anular_compra;');
        DB::unprepared('DROP TRIGGER IF EXISTS restar_stock_al_vender;');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_anular_venta;');
        DB::unprepared('DROP TRIGGER IF EXISTS restar_stock_al_agregar_carrito;');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_cancelar_carrito;');

        DB::unprepared('DROP TRIGGER IF EXISTS actualizar_caja_al_insertar_venta');
        DB::unprepared('DROP TRIGGER IF EXISTS actualizar_caja_al_cancelar_venta');
    }
};
