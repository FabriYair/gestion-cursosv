<?php

namespace App\Mail;

use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatriculaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Curso $curso,
        public Estudiante $estudiante
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Matrícula confirmada'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.matricula-confirmada'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
