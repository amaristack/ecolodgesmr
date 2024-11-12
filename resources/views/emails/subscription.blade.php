<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscription</title>
    <style>
        /* Basic Reset and Tailwind-inspired utility classes for email styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .text-center {
            text-align: center;
        }
        .text-xl {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }
        .text-gray-600 {
            color: #4b5563;
        }
        .text-blue-600 {
            color: #2563eb;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .p-4 {
            padding: 1rem;
        }
        .bg-blue-600 {
            background-color: #2563eb;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
        }
        .rounded-md {
            border-radius: 0.375rem;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container rounded-md shadow-lg p-4">
    <h2 class="text-center text-xl mt-4">Welcome to Our Newsletter!</h2>
    <p class="text-center text-gray-600 mt-4">
        Hello! Thanks for subscribing to our newsletter. We’re thrilled to have you on board.
    </p>

    <p class="text-center text-gray-600 mt-4">
        We'll keep you updated with the latest news, exclusive offers, and special promotions. Stay tuned!
    </p>

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="bg-blue-600 text-white rounded-md shadow-lg">
            Visit Our Website
        </a>
    </div>

    <p class="text-center text-gray-600 mt-4">
        If you didn’t subscribe to our newsletter or would like to unsubscribe, please ignore this email or contact us for support.
    </p>

    <p class="text-center text-blue-600 mt-4">
        - The Team at Our Company
    </p>
</div>
</body>
</html>
