<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = getDB();
$stmt = $db->prepare("SELECT priority, COUNT(*) as count FROM notes GROUP BY priority");
$stmt->execute();
$priorityData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create a new image
$imageWidth = 400;
$imageHeight = 300;
$image = imagecreatetruecolor($imageWidth, $imageHeight);

// Colors
$backgroundColor = imagecolorallocate($image, 255, 255, 255); // white
$barColor = imagecolorallocate($image, 0, 123, 255); // blue
$textColor = imagecolorallocate($image, 0, 0, 0); // black

// Fill the background
imagefill($image, 0, 0, $backgroundColor);

// Define bar width and spacing
$barWidth = 40;
$spacing = 10;
$x = 30; // Initial X position for the first bar

$maxHeight = max(array_column($priorityData, 'count'));
$adjustHeight = ($imageHeight - 60) / $maxHeight; // Adjust the height to fit the bars

// Draw bars for each priority
foreach ($priorityData as $data) {
    $priority = $data['priority'];
    $count = $data['count'];

    // Calculate the bar height based on count
    $barHeight = $count * $adjustHeight; // Scaling factor, adjust based on your needs

    // Draw the bar
    imagefilledrectangle($image, $x, $imageHeight - 30, $x + $barWidth, $imageHeight - 30 - $barHeight, $barColor);

    // Add text label for priority
    imagestring($image, 5, $x + 10, $imageHeight - 25, " " . $priority, $textColor);

    // Add count label at the top of the bar
    imagestring($image, 5, $x + 10, $imageHeight - 30 - $barHeight - 20, $count, $textColor);

    // Move the X position for the next bar
    $x += $barWidth + $spacing;
}

// Output the image
header("Content-Type: image/png");
imagepng($image);

?>
