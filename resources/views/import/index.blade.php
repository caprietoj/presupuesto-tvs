<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Importar Archivo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <link rel="stylesheet" href="{{ asset('css/import.css') }}">
                    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf

                        <div class="form-group">
                            <label for="file" class="form-label">Seleccionar archivo Excel</label>
                            <input type="file" name="file" id="file" accept=".xlsx,.xls" class="form-control" required>
                            <p class="form-text">El archivo debe tener las columnas: Fuente, Documento, Fecha, Cuenta, Descripción, Valor, etc.</p>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Importar
                        </button>
                    </form>

                    @if(session('success'))
                        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>