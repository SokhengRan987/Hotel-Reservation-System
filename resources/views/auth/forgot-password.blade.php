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

        .forgot-card {
            background: rgba(30, 60, 114, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .forgot-card h1 {
            text-align: center;
            color: white;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            text-align: center;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            padding-left: 45px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 15px;
            font-weight: 400;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(255, 200, 100, 0.2);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
            pointer-events: none;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 20px;
            background: white;
            color: #1e3c72;
            border: none;
            border-radius: 50px;
            font-size: 16px;
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

        .back-link {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .back-link a {
            color: rgba(255, 200, 100, 0.9);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: rgba(255, 200, 100, 1);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 8px;
            font-weight: 500;
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
        <div class="forgot-card">
            <h1>Reset Password</h1>
            
            <p class="description">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <span class="input-icon">✉️</span>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Email Password Reset Link</button>

                <!-- Back Link -->
                <div class="back-link">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
