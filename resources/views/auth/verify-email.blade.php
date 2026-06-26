<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #374679 0%, #abb2c4 100%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                repeating-linear-gradient(90deg, rgba(215,170,70,0.03) 0px, rgba(215,170,70,0.03) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(0deg, rgba(215,170,70,0.03) 0px, rgba(215,170,70,0.03) 1px, transparent 1px, transparent 40px);
            pointer-events: none;
            z-index: 1;
        }

        body::after {
            content: '';
            position: fixed;
            top: 2%;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,200,100,0.15) 0%, transparent 70%);
            filter: blur(40px);
            z-index: 0;
            pointer-events: none;
        }

        .auth-container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .verify-card {
            background: rgba(15, 25, 55, 0.92);
            border: 1px solid rgba(215, 170, 70, 0.18);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,.45);
        }

        .verify-card h1 {
            text-align: center;
            color: white;
            font-size: 48px;
            font-family: 'Times New Roman', serif;
            margin-bottom: 20px;
        }

        .description {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            text-align: center;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #d7aa46, #f3d27b);
            color: #07132f;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            background: rgba(255,255,255,0.95);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.3);
        }

        .submit-btn:active { transform: translateY(0); }

        .logout-btn {
            width: 100%;
            padding: 15px;
            background: transparent;
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255,100,100,0.15);
            border-color: rgba(255,100,100,0.4);
            color: #ff9999;
        }

        .status-message {
            background: rgba(76,175,80,0.2);
            border: 1px solid rgba(76,175,80,0.4);
            color: #a8e6a8;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 13px;
            font-weight: 500;
        }
    </style>

    <div class="auth-container">
        <div class="verify-card">
            <h1>Verify Email</h1>

            <p class="description">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="status-message">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="button-group">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="submit-btn">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>