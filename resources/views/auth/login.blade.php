<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azrar Solutions | Portal</title>

    <link rel="stylesheet" href="/assets/kai/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/kai/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1a2035 0%, #2b3553 100%);
            --accent-color: #1572e8;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Public Sans', sans-serif;
            background-color: #fff;
        }

        .login-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side: Visual/Branding */
        .login-sidebar {
            flex: 1;
            background: var(--primary-gradient);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            position: relative;
        }

        .login-sidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
        }

        .sidebar-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        /* Right Side: Form */
        .login-form-section {
            width: 450px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            background: #fff;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 40px;
            letter-spacing: -1px;
        }

        .welcome-text h1 {
            font-weight: 700;
            color: #1a2035;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 25px;
            padding: 0;
        }

        .form-control {
            border: 2px solid #ebedf2;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: none;
            background: #fcfdfe;
        }

        .btn-login {
            background: var(--accent-color);
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 10px;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            background: #1266d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(21, 114, 232, 0.4);
        }

        @media (max-width: 992px) {
            .login-sidebar {
                display: none;
            }

            .login-form-section {
                width: 100%;
                padding: 40px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-sidebar">
            <div class="sidebar-content">
                <img src="/assets/kai/img/kaiadmin/logo_light.svg" alt="logo"
                    style="width: 80px; margin-bottom: 20px;">
                <h2 class="display-4 fw-bold">Azrar Solutions</h2>
                <p class="lead opacity-75">Streamline your workflow with our next-gen dashboard.</p>
            </div>
        </div>

        <div class="login-form-section">

            <div class="welcome-text mb-4">
                <h1>Welcome back</h1>
                <p class="text-muted">Please enter your details to sign in.</p>
            </div>

            <form action="{{ route('check_login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="fw-bold text-dark mb-2">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label class="fw-bold text-dark mb-2">Password</label>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>



                <button type="submit" class="btn btn-primary btn-login w-100">Log In</button>
            </form>


        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            let email = $('input[name="email"]').val().trim();
            let password = $('input[name="password"]').val().trim();
            let isValid = true;
            let errorMessages = [];

            // Clear previous errors
            $('.error-message').remove();

            // Validate email
            if (email === '') {
                isValid = false;
                errorMessages.push('Email is required.');
            } else {
                // Simple email regex check
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    isValid = false;
                    errorMessages.push('Enter a valid email address.');
                }
            }

            // Validate password
            if (password === '') {
                isValid = false;
                errorMessages.push('Password is required.');
            } else if (password.length < 6) {
                isValid = false;
                errorMessages.push('Password must be at least 6 characters.');
            }

            // If invalid, prevent form submission
            if (!isValid) {
                e.preventDefault(); // stop form submit

                // Show errors
                errorMessages.forEach(msg => {
                    $('form').prepend(
                        `<div class="alert alert-danger error-message">${msg}</div>`);
                });
            }
        });
    });
</script>

</html>
