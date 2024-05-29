<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h2 class="font-bold text-2xl">Empleados</h2>
                <div class="flex  py-4 items-center">
                    <x-input class="flex-1 mr-4" placeholder="Escriba que quiere buscar" type="text"
                        wire:model.live="search" />
                    {{-- @livewire('create-medicine') --}}
                    <x-add-button wire:click="$set('openCreate',true)">Agregar</x-add-button>
                </div>
                @if ($employees->count())
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
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Telefono
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Edad
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Genero
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Rol
                                </th>
                                </th>
                                <th scope="col" class="cursor-pointer px-6 py-2 font-bold text-gray-900">Editar
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50 text-center items-center"
                                    wire:key="employee-{{ $employee->id }}">
                                    <td class="px-6 py-4">{{ $employee->id }}</td>
                                    <td class="px-6 py-4">{{ $employee->full_name }}</td>
                                    <td class="px-6 py-4">{{ $employee->document_number }}</td>
                                    <td class="px-6 py-4">{{ $employee->phone }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($employee->birthdate)->age }} años
                                    </td>
                                    <td class="px-6 py-4">{{ $employee->sex }}</td>
                                    <td class="px-6 py-4">{{ $employee->role }}</td>
                                    <td class="px-6 py-4">
                                        <x-button wire:click="edit({{ $employee->id }})"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $employees->links() }}
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
                    Registrar un nuevo empleado
                </x-slot>
                <x-slot name="content">
                    <div class="mb-4">
                        <x-label value="Nombre completo" />
                        <x-input required type="text" class="w-full" wire:model="employeeCreate.full_name" />
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Tipo de documento" />
                            <x-select wire:model="employeeCreate.document_type_id" class="w-full form-select">
                                <option>Seleccione un tipo de documento</option>
                                @foreach ($documents_type as $document_type)
                                    <option value="{{ $document_type->id }}">
                                        {{ $document_type->document_type }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Nro de documento" />
                            <x-input required type="text" class="w-full"
                                wire:model="employeeCreate.document_number" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-label value="Telefono movil" />
                        <x-input required type="tel" class="w-full" wire:model="employeeCreate.phone" />
                    </div>
                    <div class="mb-4">
                        <x-label value="Correo electronico" />
                        <x-input required type="tel" class="w-full" wire:model="employeeCreate.email" />
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Fecha de nacimiento" />
                            <x-input required type="date" class="w-full" wire:model="employeeCreate.birthdate" />
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Genero" />
                            <x-select wire:model="employeeCreate.sex" class="w-full form-select">
                                <option>Seleccione un tipo de genero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Nacionalidad" />
                            <x-input required type="text" class="w-full"
                                wire:model="employeeCreate.nationality" />
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Rol" />
                            <x-input required type="text" class="w-full" wire:model="employeeCreate.role" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-label value="Direccion" />
                        <x-input required type="text" class="w-full" wire:model="employeeCreate.address" />
                    </div>

                </x-slot>
                <x-slot name="footer">
                    <x-button class="mr-3">Registrar</x-button>
                    <x-danger-button wire:click="$set('openCreate',false)">Cancelar</x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </form>

        {{-- Modal para modificar --}}
        <form wire:submit="update">
            <x-dialog-modal wire:model="openEdit">
                <x-slot name="title">
                    Modificar empleado
                </x-slot>
                <x-slot name="content">
                    <div class="mb-4">
                        <x-label value="Nombre completo" />
                        <x-input required type="text" class="w-full" wire:model="employeeEdit.full_name" />
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Tipo de documento" />
                            <x-select wire:model="employeeEdit.document_type_id" class="w-full form-select">
                                <option>Seleccione un tipo de documento</option>
                                @foreach ($documents_type as $document_type)
                                    <option value="{{ $document_type->id }}">
                                        {{ $document_type->document_type }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Nro de documento" />
                            <x-input required type="text" class="w-full"
                                wire:model="employeeEdit.document_number" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-label value="Telefono movil" />
                        <x-input required type="tel" class="w-full" wire:model="employeeEdit.phone" />
                    </div>
                    <div class="mb-4">
                        <x-label value="Correo electronico" />
                        <x-input required type="tel" class="w-full" wire:model="employeeEdit.email" />
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Fecha de nacimiento" />
                            <x-input required type="date" class="w-full" wire:model="employeeEdit.birthdate" />
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Genero" />
                            <x-select wire:model="employeeEdit.sex" class="w-full form-select">
                                <option>Seleccione un tipo de genero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Masculino</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="mb-4 flex">
                        <div class="w-1/2">
                            <x-label value="Nacionalidad" />
                            <x-input required type="text" class="w-full"
                                wire:model="employeeEdit.nationality" />
                        </div>
                        <div class="w-1/2 ml-4">
                            <x-label value="Rol" />
                            <x-input required type="text" class="w-full" wire:model="employeeEdit.role" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-label value="Direccion" />
                        <x-input required type="text" class="w-full" wire:model="employeeEdit.address" />
                    </div>

                </x-slot>
                <x-slot name="footer">
                    <x-button class="mr-3">Modificar</x-button>
                    <x-danger-button wire:click="$set('openEdit',false)">Cancelar</x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </form>

    </x-app-layout>
</div>
