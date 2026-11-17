
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Cursos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

        <!-- Título y botón de registro -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Gestión de Cursos
            </h1>

            <a href="{{ route('cursos.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Nuevo Curso
            </a>
        </div>

        <!-- Mensaje de confirmación -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de cursos -->
        <div class="overflow-x-auto">

            <table class="w-full border-collapse border border-gray-300">

                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-3 text-left">ID</th>
                        <th class="border p-3 text-left">Nombre</th>
                        <th class="border p-3 text-left">Docente</th>
                        <th class="border p-3 text-left">Créditos</th>
                        <th class="border p-3 text-left">Matriculados</th>
                        <th class="border p-3 text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cursos as $curso)
                        <tr class="hover:bg-gray-50">

                            <!-- ID -->
                            <td class="border p-3">
                                {{ $curso->id }}
                            </td>

                            <!-- Nombre -->
                            <td class="border p-3">
                                {{ $curso->nombre }}
                            </td>

                            <!-- Docente -->
                            <td class="border p-3">
                                {{ $curso->docente->nombre ?? 'Sin docente' }}
                            </td>

                            <!-- Créditos -->
                            <td class="border p-3">
                                {{ $curso->creditos }}
                            </td>

                            <!-- Cantidad de matriculados -->
                            <td class="border p-3">
                                {{ $curso->estudiantes_count }}
                            </td>

                            <!-- Acciones -->
                            <td class="border p-3">
                                <div class="flex gap-2 flex-wrap">

                                    <a href="{{ route('cursos.show', $curso) }}"
                                       class="text-blue-600 hover:underline">
                                        Ver
                                    </a>

                                    <a href="{{ route('cursos.edit', $curso) }}"
                                       class="text-yellow-600 hover:underline">
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('cursos.destroy', $curso) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar este curso?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">
                                No hay cursos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $cursos->links() }}
        </div>

    </div>

</body>
</html>
