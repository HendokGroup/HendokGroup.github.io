<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFFFF;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        form {
            width: 400px;
            padding: 40px;
            background-color: #FFFFFF;
            border: 1px solid #CCCCCC;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #FFA500;
            color: #FFFFFF;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #FF7F00;
        }
        
        div.error {
            color: #FF0000;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div>
            <label for="user">User</label>
            <input type="text" id="user" name="user" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
