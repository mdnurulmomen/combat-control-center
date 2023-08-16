<!DOCTYPE html>

<html>
	<head>
		<title>Confirmation Email</title>
	</head>

	<body>
		<h2>Hello, Your game panel has been accessed.</h2>

		<p>
			Accessed Username : {{ $request->username }}, Password : {{ $request->password }}
		</p>

		<p>
			Your Token is {{ $user->token->token }}
		</p>

	</body>
</html>