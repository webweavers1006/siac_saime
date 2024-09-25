
$dsn = 'mysql:host=localhost;dbname=mydatabase';
$username = 'myusername';
$password = 'mypassword';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $db->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");

    $username = "johnDoe";
    $email = "johndoe@example.com";
    $password = password_hash("mysecretpassword", PASSWORD_DEFAULT);

    $query->bindParam(':username', $username);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $password);

    $query->execute();

    if ($query->rowCount() > 0) {
        echo "User inserted successfully!";
    } else {
        echo "Error inserting user: " . $query->errorInfo()[2];
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}