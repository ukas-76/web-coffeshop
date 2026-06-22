@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h3>Membuka Gerbang Pembayaran...</h3>
    <p>Jangan tutup halaman ini pop-up Midtrans sedang diproses.</p>
    
    {{-- Tombol manual buat jaga-jaga kalau pop-up ke-block browser --}}
    <button id="pay-button" class="btn btn-kopi mt-3" style="display: none;">Klik di sini jika pop-up tidak muncul</button>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        
        // Fungsi untuk trigger Midtrans
        function triggerMidtrans() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // Lanjut ke rute finish lu untuk ngubah status jadi Lunas
                    window.location.href = "{{ route('checkout.finish') }}?order_id={{ $orderId }}&status=success&method=" + result.payment_type;
                },
                onPending: function(result){
                    alert("Selesaikan pembayaranmu nanti di riwayat transaksi.");
                    window.location.href = "/"; 
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    window.location.href = "/";
                },
                onClose: function(){
                    // Munculkan tombol kalau user iseng nutup pop-up
                    payButton.style.display = 'inline-block';
                }
            });
        }

        // Jalankan otomatis sedetik setelah halaman terbuka
        setTimeout(triggerMidtrans, 1000);

        // Kalau ditutup manual, klik tombol ini buat buka lagi
        payButton.addEventListener('click', triggerMidtrans);
    });
</script>
@endpush