<div class="p-1 lg:p-2 bg-white border-b border-gray-200">
    <div class="bg-orange-100 border-t border-b border-orange-500 text-orange-700 px-4 py-3" role="alert">
        <p class="font-bold">Bienvenido {{ Auth::user()->name }} al sistema de plantilla de pagos de Preventiva !!</p>
        <p class="text-sm">En el sistema podra registrar los pagos de los empleados registrados</p>
    </div>
    <div>
        <img class="mt-5 h-auto max-w-4xl mx-auto rounded-lg shadow-xl dark:shadow-gray-400"
            src="{{ asset('storage/' . 'preventiva/Frontis.jpg') }}" alt="image description">
    </div>
</div>
