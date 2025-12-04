<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReviewThankYouMail;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product
     * SRS-MartPlace-06: Pemberian komentar dan rating
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Nomor HP harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
        ]);

        // Create review
        $review = Review::create([
            'product_id' => $product->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Send thank you email notification (SRS requirement)
        try {
            Mail::to($validated['email'])->send(new ReviewThankYouMail($review, $product));
        } catch (\Exception $e) {
            // Log error but don't fail the review submission
            Log::error('Failed to send review thank you email: ' . $e->getMessage());
        }

        return redirect()
            ->route('catalog.show', $product->slug)
            ->with('success', 'Terima kasih! Review Anda telah berhasil dikirim. Cek email Anda untuk konfirmasi.');
    }
}
