<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih atas Review Anda</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .product-info {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .product-name {
            font-weight: 600;
            color: #667eea;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .stars {
            color: #fbbf24;
            font-size: 18px;
            margin: 10px 0;
        }
        .review-text {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-style: italic;
            color: #555;
        }
        .message {
            color: #555;
            margin: 15px 0;
            line-height: 1.8;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
        }
        .button:hover {
            background-color: #5568d3;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Terima Kasih atas Review Anda!</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Halo <strong>{{ $review->name }}</strong>,</p>
            
            <p class="message">
                Terima kasih telah meluangkan waktu untuk memberikan review pada produk kami. 
                Masukan Anda sangat berarti bagi kami dan membantu pembeli lain dalam mengambil keputusan.
            </p>

            <div class="product-info">
                <div class="product-name">📦 {{ $product->name }}</div>
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            ⭐
                        @else
                            ☆
                        @endif
                    @endfor
                    <span style="color: #333; font-size: 14px;">({{ $review->rating }}/5)</span>
                </div>
                @if($review->comment)
                    <div class="review-text">
                        "{{ $review->comment }}"
                    </div>
                @endif
            </div>

            <p class="message">
                Review Anda akan membantu pembeli lain untuk mengetahui kualitas produk ini. 
                Kami berkomitmen untuk terus meningkatkan kualitas produk dan layanan kami.
            </p>

            <center>
                <a href="{{ route('catalog.show', $product->slug) }}" class="button">
                    Lihat Produk
                </a>
            </center>

            <p class="message" style="margin-top: 30px;">
                Jika Anda memiliki pertanyaan atau masukan lebih lanjut, jangan ragu untuk menghubungi kami.
            </p>

            <p class="message">
                Salam hangat,<br>
                <strong>Tim PojokKampus</strong>
            </p>
        </div>

        <div class="footer">
            <p>
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
                <a href="{{ url('/') }}">PojokKampus</a> - Platform Jual Beli Mahasiswa
            </p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                © {{ date('Y') }} PojokKampus. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
