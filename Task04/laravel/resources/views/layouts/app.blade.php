<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игра «НОД»</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 700px;
        }

        h1 {
            text-align: center;
            margin-bottom: 24px;
            color: #2c3e50;
            font-size: 28px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 16px;
        }

        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 24px;
            font-size: 16px;
        }

        .center {
            text-align: center;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #34495e;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 12px;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 4px;
            text-decoration: none;
            transition: transform 0.1s;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: #fff;
        }

        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }

        .btn-gray {
            background: #bdc3c7;
            color: #2c3e50;
        }

        .numbers-display {
            text-align: center;
            font-size: 48px;
            font-weight: bold;
            color: #2c3e50;
            margin: 24px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .round-info {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .result-box {
            padding: 14px;
            border-radius: 8px;
            margin: 12px 0;
            font-weight: 600;
            text-align: center;
            font-size: 16px;
        }

        .result-correct {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .result-incorrect {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .score {
            text-align: center;
            font-size: 64px;
            font-weight: bold;
            color: #2c3e50;
            margin: 16px 0 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            background: #667eea;
            color: #fff;
            padding: 10px 8px;
            font-size: 14px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            text-align: center;
            font-size: 14px;
        }

        tr:hover td {
            background: #f8f9fa;
        }

        a.link {
            color: #667eea;
            font-weight: 600;
        }

        .empty-msg {
            color: #999;
            padding: 24px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>🔢 Наибольший общий делитель</h1>
        @yield('content')
    </div>
</body>

</html>