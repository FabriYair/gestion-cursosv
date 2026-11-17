
<x-mail::message>
# Matrícula confirmada

Hola, **{{ $estudiante->nombre }}**.

Te informamos que tu matrícula se ha registrado correctamente en nuestro sistema de Gestión de Cursos.

## Detalles de tu matrícula

**Estudiante:** {{ $estudiante->nombre }}

**Correo:** {{ $estudiante->email }}

**Curso:** {{ $curso->nombre }}

**Docente:** {{ $curso->docente?->nombre ?? 'Sin docente' }}

**Créditos:** {{ $curso->creditos }}

Tu inscripción ha sido confirmada satisfactoriamente.

Gracias por utilizar nuestro sistema académico.

Atentamente,  
**Gestión de Cursos**

</x-mail::message>
