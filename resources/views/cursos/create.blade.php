
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Curso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Registrar Nuevo Curso
        </h1>

        @if ($errors->any())
            <div class="mb-5 rounded border border-red-300 bg-red-50 p-4 text-red-800">
                <p class="font-semibold mb-2">
                    Corrige los siguientes errores:
                </p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cursos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block mb-2 font-medium">
                    Nombre del curso
                </label>
                <input id="nombre"
                       type="text"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       required
                       maxlength="100"
                       class="w-full border rounded p-2">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block mb-2 font-medium">
                    Descripción
                </label>
                <textarea id="descripcion"
                          name="descripcion"
                          rows="3"
                          class="w-full border rounded p-2">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="creditos" class="block mb-2 font-medium">
                    Créditos
                </label>
                <input id="creditos"
                       type="number"
                       name="creditos"
                       value="{{ old('creditos') }}"
                       min="1"
                       max="10"
                       required
                       class="w-full border rounded p-2">
                @error('creditos')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="docente_id" class="block mb-2 font-medium">
                    Docente
                </label>
                <select id="docente_id"
                        name="docente_id"
                        required
                        class="w-full border rounded p-2">
                    <option value="">Seleccione un docente</option>
                    @foreach ($docentes as $docente)
                        <option value="{{ $docente->id }}"
                            @selected(old('docente_id') == $docente->id)>
                            {{ $docente->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('docente_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                    Guardar Curso
                </button>

                <a href="{{ route('cursos.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
