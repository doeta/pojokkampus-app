<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $seller;
    protected $status;
    protected $rejectionReason;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, string $status, ?string $rejectionReason = null)
    {
        $this->seller = $seller;
        $this->status = $status;
        $this->rejectionReason = $rejectionReason;
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
        if ($this->status === 'approved') {
            return $this->approvalMail($notifiable);
        }

        return $this->rejectionMail($notifiable);
    }

    /**
     * Build approval email.
     */
    protected function approvalMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Verifikasi Penjual Diterima - ' . config('app.name'))
            ->greeting('Halo ' . $this->seller->nama_pic . ',')
            ->line('**Selamat!** Verifikasi pendaftaran Anda sebagai penjual di ' . config('app.name') . ' telah **DITERIMA**.')
            ->line('')
            ->line('**Detail Toko:**')
            ->line('- Nama Toko: ' . $this->seller->nama_toko)
            ->line('- Email: ' . $notifiable->email)
            ->line('')
            ->line('**🎉 Akun Anda Telah Diaktivasi**')
            ->line('Akun Anda sekarang sudah aktif dan dapat digunakan untuk:')
            ->line('✓ Login ke dashboard penjual')
            ->line('✓ Mengunggah dan mengelola produk')
            ->line('✓ Memproses pesanan')
            ->line('✓ Melihat laporan penjualan')
            ->line('')
            ->action('Login Sekarang', url('/login'))
            ->line('Terima kasih telah bergabung dengan kami!')
            ->salutation('Salam, Tim ' . config('app.name'));
    }

    /**
     * Build rejection email.
     */
    protected function rejectionMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Verifikasi Penjual Ditolak - ' . config('app.name'))
            ->greeting('Halo ' . $this->seller->nama_pic . ',')
            ->line('Mohon maaf, pendaftaran Anda sebagai penjual di ' . config('app.name') . ' **tidak dapat kami setujui**.')
            ->line('')
            ->line('**📋 Informasi Penolakan:**')
            ->line('Alasan: ' . $this->rejectionReason)
            ->line('')
            ->line('**Detail Pendaftaran:**')
            ->line('- Nama Toko: ' . $this->seller->nama_toko)
            ->line('- Email: ' . $notifiable->email)
            ->line('- PIC: ' . $this->seller->nama_pic)
            ->line('')
            ->line('**Apa yang bisa Anda lakukan?**')
            ->line('• Melengkapi dokumen/persyaratan yang kurang')
            ->line('• Memperbaiki data sesuai alasan penolakan')
            ->line('• Mendaftar ulang setelah memperbaiki kekurangan')
            ->line('• Menghubungi tim support untuk klarifikasi')
            ->line('')
            ->action('Daftar Ulang', url('/register-seller'))
            ->line('Terima kasih atas pengertian Anda.')
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
            'status' => $this->status,
            'rejection_reason' => $this->rejectionReason,
        ];
    }
}
