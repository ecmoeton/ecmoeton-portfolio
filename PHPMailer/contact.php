<?php
// Allow requests from anywhere (for development, change this in production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Read JSON input from fetch request
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($data["name"] ?? "");
    $email = htmlspecialchars($data["email"] ?? "");
    $message = htmlspecialchars($data["message"] ?? "");

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Example: Send email (replace with your mail setup)
        $to = "lizzy@moeton.com";  // Replace with your email
        $subject = "New Contact Message from $name";
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            echo json_encode(["success" => "Message sent successfully!"]);
        } else {
            echo json_encode(["error" => "Failed to send message."]);
        }
    } else {
        echo json_encode(["error" => "All fields are required."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
