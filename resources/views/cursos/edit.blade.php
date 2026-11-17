
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Editar Curso
        </h1>

        <form action="{{ route('cursos.update', $curso) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nombre del curso
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $curso->nombre) }}"
                       maxlength="100"
                       required
                       class="w-full border rounded p-2">

                @error('nombre')
                    <p class="text-red-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Descripción
                </label>

                <textarea name="descripcion"
                          rows="3"
                          class="w-full border rounded p-2">{{ old('descripcion', $curso->descripcion) }}</textarea>

                @error('descripcion')
                    <p class="text-red-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Créditos
                </label>

                <input type="number"
                       name="creditos"
                       value="{{ old('creditos', $curso->creditos) }}"
                       min="1"
                       max="10"
                       required
                       class="w-full border rounded p-2">

                @error('creditos')
                    <p class="text-red-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">
                    Docente
                </label>

                <select name="docente_id"
                        required
                        class="w-full border rounded p-2">

                    <option value="">
                        Seleccione un docente
                    </option>

                    @foreach($docentes as $docente)
                        <option value="{{ $docente->id }}"
                            @selected(
                                old('docente_id', $curso->docente_id)
                                == $docente->id
                            )>
                            {{ $docente->nombre }}
                        </option>
                    @endforeach

                </select>

                @error('docente_id')
                    <p class="text-red-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-3">

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded">
                    Actualizar Curso
                </button>

                <a href="{{ route('cursos.index') }}"
                   class="bg-gray-200 px-5 py-2 rounded">
                    Cancelar
                </a>

            </div>

        </form>
    </div>

</body>
</html>
