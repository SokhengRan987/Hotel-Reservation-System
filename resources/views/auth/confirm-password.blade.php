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

        .confirm-card {
            background: rgba(15, 25, 55, 0.92);
            border: 1px solid rgba(215, 170, 70, 0.18);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,.45);
        }

        .confirm-card h1 {
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

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 18px 15px 48px;
            border: 1px solid rgba(215,170,70,.25);
            border-radius: 12px;
            background: rgba(255,255,255,.06);
            color: white;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-input::placeholder { color: rgba(255,255,255,0.6); }

        .form-input:focus {
            outline: none;
            border-color: rgba(215,170,70,0.8);
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 20px rgba(215,170,70,0.3);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            line-height: 1;
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

        .error-message {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 8px;
            font-weight: 500;
        }
    </style>

    <div class="auth-container">
        <div class="confirm-card">
            <h1>Confirm</h1>

            <p class="description">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Password" required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <button type="submit" class="submit-btn">Confirm</button>
            </form>
        </div>
    </div>
</x-guest-layout>