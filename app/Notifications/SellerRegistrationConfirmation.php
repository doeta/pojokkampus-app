<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerRegistrationConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Konfirmasi Pendaftaran Penjual - ' . config('app.name'))
            ->greeting('Halo ' . $this->seller->nama_pic . ',')
            ->line('Terima kasih telah mendaftar sebagai penjual di ' . config('app.name') . '!')
            ->line('')
            ->line('**Detail Pendaftaran:**')
            ->line('- Nama Toko: ' . $this->seller->nama_toko)
            ->line('- Email: ' . $notifiable->email)
            ->line('- PIC: ' . $this->seller->nama_pic)
            ->line('')
            ->line('**Status:** Menunggu Verifikasi')
            ->line('')
            ->line('Pendaftaran Anda sedang dalam proses verifikasi kelengkapan syarat administrasi oleh tim kami.')
            ->line('Anda akan menerima **notifikasi email** dengan hasil verifikasi:')
            ->line('- **Email Diterima:** Akun Anda akan diaktivasi dan siap digunakan')
            ->line('- **Email Ditolak:** Berisi informasi alasan penolakan')
            ->line('')
            ->line('Proses verifikasi biasanya memakan waktu 1-3 hari kerja.')
            ->line('')
            ->line('Terima kasih atas kesabaran Anda!')
            ->salutation('Salam, Tim ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'seller_id' => $this->seller->id,
            'nama_toko' => $this->seller->nama_toko,
        ];
    }
}
