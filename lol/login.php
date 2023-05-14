<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <style>
    body {
      background-color: <?php echo isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '#7ebfb3'; ?>;
    }
  </style>
</head>
<body>
  <h1>Login Page</h1>
  <p>Welcome to the login page.</p>

  <a href="hello.html">Go back to Hello Page 1</a>

  <script src="hello.js"></script>
</body>
</html>
