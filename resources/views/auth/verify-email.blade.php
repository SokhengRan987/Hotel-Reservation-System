<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #001a4d 0%, #003d99 50%, #001a4d 100%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: whitesmoke
                repeating-linear-gradient(
                    90deg,
                    rgba(255,255,255,0.03) 0px,
                    rgba(255,255,255,0.03) 1px,
                    transparent 1px,
                    transparent 40px
                ),
                repeating-linear-gradient(
                    0deg,
                    rgba(255,255,255,0.03) 0px,
                    rgba(255,255,255,0.03) 1px,
                    transparent 1px,
                    transparent 40px
                );  
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
            background: rgba(30, 60, 114, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .verify-card h1 {
            text-align: center;
            color: white;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            text-align: center;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 12px;
            flex-direction: column;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 20px;
            background: white;
            color: #1e3c72;
            border: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .submit-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .logout-btn {
            width: 100%;
            padding: 14px 20px;
            background: rgba(255, 100, 100, 0.15);
            color: rgba(255, 200, 100, 0.9);
            border: 1px solid rgba(255, 100, 100, 0.3);
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 100, 100, 0.25);
            border-color: rgba(255, 100, 100, 0.5);
        }

        .status-message {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.4);
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
