<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Sumar stock al crear compra
        DB::unprepared('
            CREATE OR REPLACE FUNCTION sumar_stock_al_crear_compra_func()
            RETURNS TRIGGER AS $$
            BEGIN
                IF NEW."ESTADO" = 1 THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" + (
                        SELECT "CANTIDAD"
                        FROM "DETALLE_COMPRA"
                        WHERE "DETALLE_COMPRA"."PRODUCTO" = "PRODUCTO"."ID"
                        AND "DETALLE_COMPRA"."COMPRA" = NEW."ID"
                    )
                    WHERE "ID" IN (
                        SELECT "PRODUCTO"
                        FROM "DETALLE_COMPRA"
                        WHERE "COMPRA" = NEW."ID"
                    );
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER sumar_stock_al_crear_compra
            AFTER INSERT ON "COMPRA"
            FOR EACH ROW EXECUTE FUNCTION sumar_stock_al_crear_compra_func();
        ');

        // Devolver stock al anular compra
        DB::unprepared('
            CREATE OR REPLACE FUNCTION devolver_stock_al_anular_compra_func()
            RETURNS TRIGGER AS $$
            BEGIN
                IF OLD."ESTADO" = 1 AND NEW."ESTADO" = 0 THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" - (
                        SELECT "CANTIDAD"
                        FROM "DETALLE_COMPRA"
                        WHERE "DETALLE_COMPRA"."PRODUCTO" = "PRODUCTO"."ID"
                        AND "DETALLE_COMPRA"."COMPRA" = NEW."ID"
                        LIMIT 1
                    )
                    WHERE "ID" IN (
                        SELECT "PRODUCTO"
                        FROM "DETALLE_COMPRA"
                        WHERE "COMPRA" = NEW."ID"
                    );
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_anular_compra
            AFTER UPDATE ON "COMPRA"
            FOR EACH ROW EXECUTE FUNCTION devolver_stock_al_anular_compra_func();
        ');

        // Restar stock al vender
        DB::unprepared('
            CREATE OR REPLACE FUNCTION restar_stock_al_vender_func()
            RETURNS TRIGGER AS $$
            DECLARE
                venta_estado boolean;
            BEGIN
                SELECT "ESTADO" INTO venta_estado FROM "VENTA" WHERE "ID" = NEW."VENTA";
                IF venta_estado = 1 THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" - NEW."CANTIDAD"
                    WHERE "ID" = NEW."PRODUCTO";
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER restar_stock_al_vender
            AFTER INSERT ON "DETALLE_VENTA"
            FOR EACH ROW EXECUTE FUNCTION restar_stock_al_vender_func();
        ');

        // Devolver stock al anular venta
        DB::unprepared('
            CREATE OR REPLACE FUNCTION devolver_stock_al_anular_venta_func()
            RETURNS TRIGGER AS $$
            BEGIN
                IF OLD."ESTADO" = 1 AND NEW."ESTADO" = 0 THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" + (
                        SELECT "CANTIDAD"
                        FROM "DETALLE_VENTA"
                        WHERE "PRODUCTO" = "PRODUCTO"."ID"
                        AND "VENTA" = NEW."ID"
                    )
                    WHERE "ID" IN (
                        SELECT "PRODUCTO"
                        FROM "DETALLE_VENTA"
                        WHERE "VENTA" = NEW."ID"
                    );
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_anular_venta
            AFTER UPDATE OF "ESTADO" ON "VENTA"
            FOR EACH ROW EXECUTE FUNCTION devolver_stock_al_anular_venta_func();
        ');

        // Restar stock al agregar al carrito
        DB::unprepared('
            CREATE OR REPLACE FUNCTION restar_stock_al_agregar_carrito_func()
            RETURNS TRIGGER AS $$
            DECLARE
                carrito_estado boolean;
            BEGIN
                SELECT "ESTADO" INTO carrito_estado FROM "CARRITO" WHERE "ID" = NEW."CARRITO";
                IF carrito_estado IS TRUE THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" - NEW."CANTIDAD"
                    WHERE "ID" = NEW."PRODUCTO";
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER restar_stock_al_agregar_carrito
            AFTER INSERT ON "DETALLE_CARRITO"
            FOR EACH ROW EXECUTE FUNCTION restar_stock_al_agregar_carrito_func();
        ');

        // Devolver stock al cancelar carrito
        DB::unprepared('
            CREATE OR REPLACE FUNCTION devolver_stock_al_cancelar_carrito_func()
            RETURNS TRIGGER AS $$
            BEGIN
                IF OLD."ESTADO" = 1 AND NEW."ESTADO" = 0 THEN
                    UPDATE "PRODUCTO"
                    SET "CANTIDAD" = "CANTIDAD" + (
                        SELECT "CANTIDAD"
                        FROM "DETALLE_CARRITO"
                        WHERE "PRODUCTO" = "PRODUCTO"."ID"
                        AND "CARRITO" = NEW."ID"
                    )
                    WHERE "ID" IN (
                        SELECT "PRODUCTO"
                        FROM "DETALLE_CARRITO"
                        WHERE "CARRITO" = NEW."ID"
                    );
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER devolver_stock_al_cancelar_carrito
            AFTER UPDATE OF "ESTADO" ON "CARRITO"
            FOR EACH ROW EXECUTE FUNCTION devolver_stock_al_cancelar_carrito_func();
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS sumar_stock_al_crear_compra ON "COMPRA";');
        DB::unprepared('DROP FUNCTION IF EXISTS sumar_stock_al_crear_compra_func();');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_anular_compra ON "COMPRA";');
        DB::unprepared('DROP FUNCTION IF EXISTS devolver_stock_al_anular_compra_func();');
        DB::unprepared('DROP TRIGGER IF EXISTS restar_stock_al_vender ON "DETALLE_VENTA";');
        DB::unprepared('DROP FUNCTION IF EXISTS restar_stock_al_vender_func();');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_anular_venta ON "VENTA";');
        DB::unprepared('DROP FUNCTION IF EXISTS devolver_stock_al_anular_venta_func();');
        DB::unprepared('DROP TRIGGER IF EXISTS restar_stock_al_agregar_carrito ON "DETALLE_CARRITO";');
        DB::unprepared('DROP FUNCTION IF EXISTS restar_stock_al_agregar_carrito_func();');
        DB::unprepared('DROP TRIGGER IF EXISTS devolver_stock_al_cancelar_carrito ON "CARRITO";');
        DB::unprepared('DROP FUNCTION IF EXISTS devolver_stock_al_cancelar_carrito_func();');
    }
};
