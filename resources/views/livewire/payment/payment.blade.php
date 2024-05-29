<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="font-bold text-2xl">Pagos de empleados</h2>
                <div class="flex  py-4 items-center">
                    <x-input class="flex-1 mr-4" placeholder="Escriba que quiere buscar" type="text"
                        wire:model.live="search" />
                    {{-- @livewire('create-medicine') --}}
                    <x-add-button wire:click="$set('openCreate',true)">Agregar</x-add-button>
                </div>
                @if ($payments->count())
                    <table class="rounded-lg w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-50">
                            <tr class="text-center">
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900 flex"
                                    wire:click="order('id')">
                                    ID
                                    @if ($sort == 'id')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900 text-center"
                                    wire:click="order('full_name')">
                                    Nombre
                                    @if ($sort == 'full_name')
                                        @if ($direction == 'asc')
                                            <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                        @else
                                            <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Numero de
                                    documento
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Monto
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Monto final
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Tipo de pago
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Metodo de
                                    pago
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Fecha y Hora
                                    del pago
                                </th>
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Bono
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Descuento
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                            @foreach ($payments as $payment)
                                <tr class="hover:bg-gray-50 text-center items-center"
                                    wire:key="payment-{{ $payment->id }}">
                                    <td class="px-6 py-4">{{ $payment->id }}</td>
                                    <td class="px-6 py-4">{{ $payment->full_name }}</td>
                                    <td class="px-6 py-4">{{ $payment->document_number }}</td>
                                    <td class="px-6 py-4">{{ $payment->amount }}</td>
                                    <td class="px-6 py-4">{{ $payment->final_amount }}</td>
                                    <td class="px-6 py-4">{{ $payment->payment_type }}</td>
                                    <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                                    <td class="px-6 py-4">{{ $payment->created_at }}</td>
                                    <td class="px-6 py-4">
                                        <x-button wire:click="openModalBond({{ $payment->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </x-button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-button wire:click="openModalDiscount({{ $payment->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div>
                        No existe ningun registro que coincida con la busquedad
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal para crear --}}
        <form wire:submit="save">
            <x-dialog-modal wire:model="openCreate">
                <x-slot name="title">
                    Registrar pago para un empleado
                </x-slot>
                <x-slot name="content">
                    <div class="mb-4" wire:ignore tabindex="-1">
                        <x-label value="Empleado" />
                        <div>
                            <x-select id="myModalEmployee" class="employees" style="width: 100%" multiple required>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->full_name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/3">
                            <x-label value="Monto de pago" />
                            <x-input required type="text" class="w-full" wire:model="paymentCreate.amount" />
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Tipo de pago" />
                            <x-select wire:model="paymentCreate.payment_type" class="w-full form-select">
                                <option>Seleccione un tipo de pago</option>
                                <option value="Quincenal">Quincenal</option>
                                <option value="Mensual">Mensual</option>
                            </x-select>
                        </div>
                        <div class="w-1/2 ml-2">
                            <x-label value="Metodo de pago" />
                            <x-select wire:model="paymentCreate.payment_method_id" class="w-full form-select">
                                <option>Seleccione un metodo de pago</option>
                                @foreach ($payment_methods as $payment_method)
                                    <option value="{{ $payment_method->id }}">
                                        {{ $payment_method->payment_method }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <x-button class="mr-3">Registrar</x-button>
                    <x-danger-button wire:click="$set('openCreate',false)">Cancelar</x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </form>
        {{-- Modal para agregar bono --}}
        <form wire:submit="saveBond">
            <x-dialog-modal wire:model="openBond">
                <x-slot name="title">
                    Registrar bono para el pago del empleado
                </x-slot>
                <x-slot name="content">
                    <div class="mb-4 flex">
                        <div class="w-1/3">
                            <x-label value="Monto de bono" />
                            <x-input required type="number" class="w-full" wire:model="bondCreate.amount" />
                        </div>
                        <div class="w-2/3 ml-4">
                            <x-label value="Descripción" />
                            <x-textarea required wire:model="bondCreate.description" class="form-control w-full" rows="3"></x-textarea>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <x-button class="mr-3">Registrar</x-button>
                    <x-danger-button wire:click="$set('openBond',false)">Cancelar</x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </form>
        {{-- Modal para agregar descuento --}}
        <form wire:submit="saveDiscount">
            <x-dialog-modal wire:model="openDiscount">
                <x-slot name="title">
                    Registrar descuento para el pago del empleado
                </x-slot>
                <x-slot name="content">
                    <div class="mb-4 flex">
                        <div class="w-1/3">
                            <x-label value="Monto de descuento" />
                            <x-input required type="number" class="w-full" wire:model="discountCreate.amount" />
                        </div>
                        <div class="w-2/3 ml-4">
                            <x-label value="Descripción" />
                            <x-textarea required wire:model="bondCreate.discount_type" class="form-control w-full" rows="3">
                            </x-textarea>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <x-button class="mr-3">Registrar</x-button>
                    <x-danger-button wire:click="$set('openDiscount',false)">Cancelar</x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </form>
        <script>
            $(document).ready(function() {
                $('.employees').select2({
                    maximumSelectionLength: 1
                });
                $('.employees').on('select2:select', function(e) {
                    var id = e.params.data.id;
                    @this.set('paymentCreate.employee_id', id)
                });
            });
        </script>
    </x-app-layout>
</div>
