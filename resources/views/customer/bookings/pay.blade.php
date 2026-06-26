@extends('layouts.customer')

@section('content')
<div style="background: #07132f ;padding: 80px 0; min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div style="background: white; border-radius: 20px; padding: 36px; box-shadow: 0 15px 50px rgba(0,0,0,0.1);">

                    <h2 style="text-align:center; color:#1e3c72; font-weight:800; margin-bottom:4px;">Sunset Haven Resort</h2>
                    <p style="text-align:center; color:#aaa; font-size:0.9rem; margin-bottom:24px;">Secure Booking Payment</p>

                    @if(session('error'))
                        <div style="background:#fde8e8; color:#c0392b; padding:12px 16px; border-radius:10px; margin-bottom:16px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Booking Summary --}}
                    <div style="background:#f8f9fa; border-radius:12px; padding:18px; margin-bottom:24px;">
                        <div style="font-weight:700; color:#1e3c72; margin-bottom:10px;">Booking Summary</div>
                        <div class="d-flex justify-content-between mb-1">
                            <span style="color:#555;">{{ $booking->room->type ?? 'Room' }}</span>
                            <span style="font-weight:700;">${{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size:0.85rem; color:#888;">
                            <span>{{ $booking->start_date->format('M d') }} – {{ $booking->end_date->format('M d, Y') }}</span>
                            <span>{{ $booking->nights }} night{{ $booking->nights !== 1 ? 's' : '' }} · {{ $booking->guest_count }} guest{{ $booking->guest_count !== 1 ? 's' : '' }}</span>
                        </div>
                        <hr style="margin:12px 0;">
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:800; font-size:1.1rem;">Total</span>
                            <span style="font-weight:800; font-size:1.2rem; color:#ff9800;">${{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    {{-- Payment Method Selector --}}
                    <div style="font-weight:700; color:#1e3c72; margin-bottom:12px;">Select Payment Method</div>
                    <div id="paymentOptions" style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">

                        <label class="pay-card" data-method="credit_card">
                            <input type="radio" name="payment_method" value="credit_card" style="display:none;">
                            <div class="d-flex align-items-center gap-3">
                                <span style="font-size:1.8rem;">💳</span>
                                <span style="font-weight:700; color:#1e3c72;">Credit Card</span>
                                <span style="color:#aaa; font-size:0.8rem; margin-left:auto;">Visa, Mastercard</span>
                            </div>
                        </label>

                        <label class="pay-card" data-method="paypal">
                            <input type="radio" name="payment_method" value="paypal" style="display:none;">
                            <div class="d-flex align-items-center gap-3">
                                <span style="font-size:1.8rem;">⚡</span>
                                <span style="font-weight:700; color:#1e3c72;">PayPal</span>
                                <span style="color:#aaa; font-size:0.8rem; margin-left:auto;">Fast & Secure</span>
                            </div>
                        </label>

                        <label class="pay-card" data-method="aba_qr">
                            <input type="radio" name="payment_method" value="aba_qr" style="display:none;">
                            <div class="d-flex align-items-center gap-3">
                                <span style="font-size:1.8rem;">📱</span>
                                <span style="font-weight:700; color:#1e3c72;">ABA QR Code</span>
                                <span style="color:#aaa; font-size:0.8rem; margin-left:auto;">ABA Mobile</span>
                            </div>
                        </label>

                        <label class="pay-card" data-method="cash">
                            <input type="radio" name="payment_method" value="cash" style="display:none;">
                            <div class="d-flex align-items-center gap-3">
                                <span style="font-size:1.8rem;">💵</span>
                                <span style="font-weight:700; color:#1e3c72;">Cash</span>
                                <span style="color:#aaa; font-size:0.8rem; margin-left:auto;">Pay at Reception</span>
                            </div>
                        </label>

                    </div>

                    {{-- Credit Card Form --}}
                    <form id="form-credit_card" class="method-form" style="display:none;"
                          method="POST" action="{{ route('customer.payment.process.card', $booking->id) }}">
                        @csrf
                        <input type="text" name="card_name" class="form-control mb-2" placeholder="Cardholder Name" required>
                        <input type="text" name="card_number" id="cardNumber" class="form-control mb-2"
                               placeholder="1234 5678 9012 3456" maxlength="19" required>
                        <div class="d-flex gap-2 mb-3">
                            <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY" maxlength="5" required>
                            <input type="text" name="card_cvv" class="form-control" placeholder="CVV" maxlength="4" required>
                        </div>
                        <button type="submit" class="btn w-100" style="background:#1e3c72; color:white; font-weight:700; padding:12px; border-radius:10px;">
                            Pay ${{ number_format($booking->total_amount, 2) }} with Card
                        </button>
                    </form>

                    {{-- PayPal Form --}}
                    <form id="form-paypal" class="method-form" style="display:none;"
                          method="POST" action="{{ route('customer.payment.process.paypal', $booking->id) }}">
                        @csrf
                        <div style="background:#fff8e1; border-radius:10px; padding:16px; text-align:center; margin-bottom:16px; color:#856404;">
                            You will complete payment securely via PayPal.
                        </div>
                        <button type="submit" class="btn w-100" style="background:#f0a500; color:white; font-weight:700; padding:12px; border-radius:10px;">
                            Pay ${{ number_format($booking->total_amount, 2) }} via PayPal
                        </button>
                    </form>

                    {{-- ABA QR Form --}}
                    <form id="form-aba_qr" class="method-form" style="display:none;"
                          method="POST" action="{{ route('customer.payment.process.aba_qr', $booking->id) }}">
                        @csrf
                        <div style="text-align:center; margin-bottom:16px;">
                            <img src="{{ asset('image/ABA-QR.jpg') }}" alt="ABA QR"
                                 style="max-width:180px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                            <div style="margin-top:10px; font-weight:700; color:#1e3c72;">
                                Scan with ABA Mobile · ${{ number_format($booking->total_amount, 2) }}
                            </div>
                        </div>
                        <button type="submit" class="btn w-100" style="background:#1e3c72; color:white; font-weight:700; padding:12px; border-radius:10px;">
                            Confirm ABA QR Payment
                        </button>
                    </form>

                    {{-- Cash Form --}}
                    <form id="form-cash" class="method-form" style="display:none;"
                          method="POST" action="{{ route('customer.payment.process.cash', $booking->id) }}">
                        @csrf
                        <div style="background:#e8f5e9; border-radius:10px; padding:16px; text-align:center; margin-bottom:16px; color:#2e7d32;">
                            Pay <strong>${{ number_format($booking->total_amount, 2) }}</strong> at the reception upon check-in.
                        </div>
                        <button type="submit" class="btn w-100" style="background:#2e7d32; color:white; font-weight:700; padding:12px; border-radius:10px;">
                            Confirm Cash Payment
                        </button>
                    </form>

                    <p style="text-align:center; color:#ccc; font-size:0.8rem; margin-top:20px;">🔒 SSL Encrypted & Secure</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pay-card {
    border: 2px solid #eee;
    border-radius: 12px;
    padding: 14px 16px;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    background: #fafafa;
    display: block;
}
.pay-card:hover { border-color: #ff9800; }
.pay-card.selected { border-color: #ff9800; background: #fffde7; }
</style>

<script>
document.querySelectorAll('.pay-card').forEach(card => {
    card.addEventListener('click', function () {
        // Highlight selected
        document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;

        // Show matching form
        document.querySelectorAll('.method-form').forEach(f => f.style.display = 'none');
        const form = document.getElementById('form-' + this.dataset.method);
        if (form) form.style.display = 'block';
    });
});

// Auto-format card number with spaces
const cardInput = document.getElementById('cardNumber');
if (cardInput) {
    cardInput.addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').substring(0, 16);
        this.value = v.replace(/(.{4})/g, '$1 ').trim();
    });
}
</script>
@endsection