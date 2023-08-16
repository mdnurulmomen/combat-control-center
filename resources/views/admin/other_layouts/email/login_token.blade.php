<!DOCTYPE html>

<html>
	<head>
		<title>Welcome Email</title>
	</head>

	<body>
		<h2>Hello, {{ $user->username }}</h2>

		<p>
			Your Login Token is {{ $user->token->token }}
		</p>
	</body>
</html>