<flux:modal name="nuevo-producto" class="w-full md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Editar Producto</flux:heading>
        </div>

        <flux:input label="Código" wire:model.defer="codigo" />
        <flux:input label="Nombre" wire:model.defer="nombre" />
        <flux:input.group>
            <flux:input.group.prefix>Bs.</flux:input.group.prefix>
            <flux:input type="number" wire:model.defer="precio" />
        </flux:input.group>

        <flux:input label="Categoría" wire:model.defer="categoria" />

        <div class="flex justify-end">
            <flux:button wire:click="guardar" variant="primary">Guardar Cambios</flux:button>
        </div>
    </div>
</flux:modal>
