<?php
// Start the session and include database connection

include('includes/header_n.php');
include('includes/dbconnect.php');

// Fetch Running Events (current or ongoing events)
$running_events_query = "SELECT * FROM events WHERE start_date <= CURDATE() AND end_date >= CURDATE()";
$running_events_result = mysqli_query($conn, $running_events_query);

// Fetch Upcoming Events (future events)
$upcoming_events_query = "SELECT * FROM events WHERE start_date > CURDATE()";
$upcoming_events_result = mysqli_query($conn, $upcoming_events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Tailwind/output.css">
    <title>Event Management System</title>
</head>
<body>

    <!-- Body Section -->
    <div class="bg-gray-100 text-gray-800">

        <!-- Hero Section -->
        <section class="relative bg-gradient-to-r from-blue-500 to-purple-600 text-white py-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Plan and Manage Your Events with Ease
                </h1>
                <p class="text-lg md:text-xl mb-8">
                    Streamline your event management process with our powerful tools and seamless experience.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="user/events.php" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded shadow hover:bg-gray-100">
                        View Events
                    </a>
                    <a href="user/events.php" class="bg-blue-600 border-2 border-white text-white font-semibold py-2 px-6 rounded hover:bg-blue-700">
                        Register Event
                    </a>
                </div>
            </div>
        </section>

        <!-- Running Events Section -->
        <section class="bg-gray-200 py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-8">Running Events</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <?php while ($event = mysqli_fetch_assoc($running_events_result)): ?>
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Use the 'image_path' from the database -->
                            <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="w-full h-40 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($event['name']) ?></h3>
                                <p class="text-gray-600 mb-4"><?= htmlspecialchars($event['description']) ?></p>
                                <span class="text-blue-500 font-bold"><?= htmlspecialchars($event['start_date']) ?> - <?= htmlspecialchars($event['end_date']) ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <!-- Upcoming Events Section -->
        <section class="bg-gray-200 py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-8">Upcoming Events</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <?php while ($event = mysqli_fetch_assoc($upcoming_events_result)): ?>
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Use the 'image_path' from the database -->
                            <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="w-full h-40 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($event['name']) ?></h3>
                                <p class="text-gray-600 mb-4"><?= htmlspecialchars($event['description']) ?></p>
                                <span class="text-blue-500 font-bold"><?= htmlspecialchars($event['start_date']) ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <section class="bg-blue-600 text-white py-12 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Pre-Register Your Next Event?</h2>
            <a href="/get-started" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded shadow hover:bg-gray-100">
                Register
            </a>
        </section>
    </div>
</body>
</html>
