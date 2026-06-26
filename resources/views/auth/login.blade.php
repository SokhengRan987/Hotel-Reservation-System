<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #374679 0%, #abb2c4 100%);
            background-attachment: fixed;
            min-height: 100vh;
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

        .login-card {
            background: rgba(15, 25, 55, 0.92);
            border: 1px solid rgba(215, 170, 70, 0.18);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,.45);
        }

        .login-card h1 {
            text-align: center;
            color: white;
            font-size: 48px;
            font-family: 'Times New Roman', serif;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;  /* ← needed for icon positioning */
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
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(215, 170, 70, 0.8);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(215, 170, 70, 0.3);
        }

        .input-icon {
            position: absolute;  /* ← was "fixed", which broke icon placement */
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
            pointer-events: none;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            margin-top: -10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: rgba(255, 200, 100, 0.8);
        }

        .remember-me label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: rgba(46, 180, 238, 0.9);
        }

        .login-btn {
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

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .register-link a {
            color: rgba(255, 200, 100, 0.9);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
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
        <div class="login-card">
            <h1>Login</h1>

            @if (session('status'))
                <div class="status-message">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <span class="input-icon">✉️</span>
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="Password" required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="login-btn">Login</button>

                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>