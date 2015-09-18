# courseNTNU
[coureNTNU.com](courseNTNU.com)

## Development

### Deployment
確定你有 php tidy, php curl, php pdo

1. Clone the Repo
2. Create database `course_ntnu` and import the latest sql file
3. `touch magic.php` and set the following
```PHP
<?php
	const USERNAME = "your_sql_username";
	const PASSWORD = "your_sql_password";
	const USOCKET = "your_sql_socket";
?>
```

### Style
- use Scss
```
scss --watch ./
```

<!--
Licence
----
-->
