<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER sumar_stock_al_crear_compra
            AFTER INSERT ON COMPRA
            FOR EACH ROW
            WHEN NEW.ESTADO = 1
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD + (
                    SELECT CANTIDAD
                    FROM DETALLE_COMPRA
                    WHERE DETALLE_COMPRA.PRODUCTO = PRODUCTO.ID
                    AND DETALLE_COMPRA.COMPRA = NEW.ID
                )
                WHERE ID IN (
                    SELECT PRODUCTO
                    FROM DETALLE_COMPRA
                    WHERE COMPRA = NEW.ID
                );
            END;
        ");
        DB::unprepared("
            CREATE TRIGGER devolver_stock_al_anular_compra
            AFTER UPDATE ON COMPRA
            WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
            BEGIN
                UPDATE PRODUCTO
                SET CANTIDAD = CANTIDAD - (
                    SELECT CANTIDAD
                    FROM DETALLE_COMPRA
                    WHERE DETALLE_COMPRA.PRODUCTO = PRODUCTO.ID
                    AND DETALLE_COMPRA.COMPRA = NEW.ID
                    LIMIT 1
                )
                WHERE ID IN (
                    SELECT PRODUCTO
                    FROM DETALLE_COMPRA
                    WHERE COMPRA = NEW.ID
                );
            END;
        ");
        DB::unprepared("
          CREATE TRIGGER restar_stock_al_vender
          AFTER INSERT ON DETALLE_VENTA
          FOR EACH ROW
          WHEN (SELECT ESTADO FROM VENTA WHERE id = NEW.VENTA) = 1
          BEGIN
            UPDATE PRODUCTO
            SET CANTIDAD = CANTIDAD - NEW.CANTIDAD
            WHERE ID = NEW.PRODUCTO;
          END;
        ");

        DB::unprepared("
          CREATE TRIGGER devolver_stock_al_anular_venta
          AFTER UPDATE OF ESTADO ON VENTA
          FOR EACH ROW
          WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
          BEGIN
            UPDATE PRODUCTO
            SET CANTIDAD = CANTIDAD + (
              SELECT CANTIDAD
              FROM DETALLE_VENTA
              WHERE PRODUCTO = PRODUCTO.ID
                AND VENTA = NEW.id
            )
            WHERE ID IN (
              SELECT PRODUCTO
              FROM DETALLE_VENTA
              WHERE VENTA = NEW.id
            );
          END;
        ");

        DB::unprepared("
          CREATE TRIGGER restar_stock_al_agregar_carrito
          AFTER INSERT ON DETALLE_CARRITO
          FOR EACH ROW
          WHEN (SELECT ESTADO FROM CARRITO WHERE ID = NEW.CARRITO) = 1
          BEGIN
            UPDATE PRODUCTO
            SET CANTIDAD = CANTIDAD - NEW.CANTIDAD
            WHERE ID = NEW.PRODUCTO;
          END;
        ");

        DB::unprepared("
          CREATE TRIGGER devolver_stock_al_cancelar_carrito
          AFTER UPDATE OF ESTADO ON CARRITO
          FOR EACH ROW
          WHEN OLD.ESTADO = 1 AND NEW.ESTADO = 0
          BEGIN
            UPDATE PRODUCTO
            SET CANTIDAD = CANTIDAD + (
              SELECT CANTIDAD
              FROM DETALLE_CARRITO
              WHERE PRODUCTO = PRODUCTO.ID
                AND CARRITO = NEW.ID
            )
            WHERE ID IN (
              SELECT PRODUCTO
              FROM DETALLE_CARRITO
              WHERE CARRITO = NEW.ID
            );
          END;
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS devolver_stock_al_anular_compra");
        DB::unprepared("DROP TRIGGER IF EXISTS sumar_stock_al_crear_compra");
        DB::unprepared("DROP TRIGGER IF EXISTS restar_stock_al_vender");
        DB::unprepared("DROP TRIGGER IF EXISTS devolver_stock_al_anular_venta");
        DB::unprepared("DROP TRIGGER IF EXISTS restar_stock_al_agregar_carrito");
        DB::unprepared("DROP TRIGGER IF EXISTS devolver_stock_al_cancelar_carrito");
    }
};
