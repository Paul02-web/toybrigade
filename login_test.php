<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Baloo 2', cursive;
            background-color: #f9f4ff;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #5a2d82;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #5a2d82;
            border-color: #5a2d82;
        }
        .btn-primary:hover {
            background-color: #3b1d5a;
            border-color: #3b1d5a;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        pre {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Test Login</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="login">Username/Role:</label>
                <input type="text" class="form-control" id="login" name="login" value="admin">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div id="result"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('login', document.getElementById('login').value);
            formData.append('password', document.getElementById('password').value);
            
            document.getElementById('result').innerHTML = '<div class="alert alert-info">Processing...</div>';
            
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                let resultClass = data.success ? 'alert alert-success' : 'alert alert-danger';
                document.getElementById('result').innerHTML = 
                    `<div class="${resultClass}">
                        <h4>${data.success ? 'Success!' : 'Error!'}</h4>
                        <pre>${JSON.stringify(data, null, 2)}</pre>
                    </div>`;
            })
            .catch(error => {
                document.getElementById('result').innerHTML = 
                    `<div class="alert alert-danger">
                        <h4>Error!</h4>
                        <pre>${error}</pre>
                    </div>`;
            });
        });
    </script>
</body>
</html>