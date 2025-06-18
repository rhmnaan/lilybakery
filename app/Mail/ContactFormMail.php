<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Properti publik untuk menyimpan data dari form

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data; // Data form akan diakses melalui $this->data di view email
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Baru dari Formulir Kontak Lily Bakery',
            from: new \Illuminate\Mail\Mailables\Address($this->data['email'], $this->data['nama_lengkap']), // Mengatur pengirim email sesuai input user
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->data['email'], $this->data['nama_lengkap']),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form', // Mengarahkan ke view email yang akan kita buat
            with: [
                'namaLengkap' => $this->data['nama_lengkap'],
                'nomorTelepon' => $this->data['nomor_telepon'],
                'emailPengirim' => $this->data['email'],
                'pesanKontak' => $this->data['pesan'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}