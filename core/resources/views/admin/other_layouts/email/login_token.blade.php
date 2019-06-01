<!DOCTYPE html>

<html>
	<head>
		<title>Welcome Email</title>
	</head>

	<body>
		<h2>Hello, {{ $user->username }}</h2>

		<br/>
			Your Token is {{ $user->token->token }}
		<br/>
	</body>
</html>