

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="Tailwind/output.css">
    </head>
    <body>
        <nav class="bg-gray-800 p-4">
                    <div class="container mx-auto flex justify-between items-center">
                         <a href="#" class="text-white text-lg font-semibold">EVENT.HOLD</a>
                         <div class="space-x-4">
                              <a href="#" class="text-gray-300 hover:text-white">Home</a>
                              <a href="#" class="text-gray-300 hover:text-white">Event</a>
                              <a href="#" class="text-gray-300 hover:text-white">Segment</a>
                              <a href="#" class="text-gray-300 hover:text-white-200">LogOut</a>
                         </div>
                    </div>
        </nav>




        <!-- body section -->
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
                    <a href="/events" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded shadow hover:bg-gray-100">
                    View Events
                    </a>
                    <a href="/create-event" class="bg-blue-600 border-2 border-white text-white font-semibold py-2 px-6 rounded hover:bg-blue-700">
                    Register Event
                    </a>
                </div>
                </div>
            </section>

           

            <!-- running event -->
            <section class="bg-gray-200 py-16">
                <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-8">Running Event</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Event Card -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image2.jpeg" alt="Event 1" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Music Fest 2024</h3>
                        <p class="text-gray-600 mb-4">Join us for an unforgettable music experience.</p>
                        <span class="text-blue-500 font-bold">March 12, 2024</span>
                    </div>
                    </div>
                    <!-- Repeat similar cards for other events -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image2.jpeg" alt="Event 2" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Tech Conference 2024</h3>
                        <p class="text-gray-600 mb-4">Explore the latest trends in technology.</p>
                        <span class="text-blue-500 font-bold">April 8, 2024</span>
                    </div>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image2.jpeg" alt="Event 3" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Art & Culture Expo</h3>
                        <p class="text-gray-600 mb-4">Celebrate art and culture from around the world.</p>
                        <span class="text-blue-500 font-bold">May 15, 2024</span>
                    </div>
                    </div>
                </div>
                </div>
            </section>

            <!-- Event Highlights Section -->
            <section class="bg-gray-200 py-16">
                <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-8">Upcoming Events</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Event Card -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image1.jpeg" alt="Event 1" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Music Fest 2024</h3>
                        <p class="text-gray-600 mb-4">Join us for an unforgettable music experience.</p>
                        <span class="text-blue-500 font-bold">March 12, 2024</span>
                    </div>
                    </div>
                    <!-- Repeat similar cards for other events -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image1.jpeg" alt="Event 2" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Tech Conference 2024</h3>
                        <p class="text-gray-600 mb-4">Explore the latest trends in technology.</p>
                        <span class="text-blue-500 font-bold">April 8, 2024</span>
                    </div>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="image1.jpeg" alt="Event 3" class="w-full h-40 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Art & Culture Expo</h3>
                        <p class="text-gray-600 mb-4">Celebrate art and culture from around the world.</p>
                        <span class="text-blue-500 font-bold">May 15, 2024</span>
                    </div>
                    </div>
                </div>
                </div>
            </section>


            <!-- Testimonials Section -->
            <section class="py-16">
                <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-8">What Our Users Say</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Testimonial Card -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 mb-4">"This platform made organizing our event so much easier!"</p>
                    <h4 class="font-semibold">- Alex Smith</h4>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 mb-4">"The best tool for event registration and management."</p>
                    <h4 class="font-semibold">- Sarah Johnson</h4>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 mb-4">"A seamless experience from start to finish."</p>
                    <h4 class="font-semibold">- Michael Lee</h4>
                    </div>
                </div>
                </div>
            </section>


             <!-- Features Section -->
             <section class="py-16">
                <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-8">Why This Website-</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Event Scheduling</h3>
                    <p class="text-gray-600">Plan and schedule events effortlessly with our intuitive interface.</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Registration Management</h3>
                    <p class="text-gray-600">Track and manage event registrations seamlessly.</p>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Customizable Themes</h3>
                    <p class="text-gray-600">Personalize your event pages to match your style and brand.</p>
                    </div>
                </div>
                </div>
            </section>

            <!-- Call-to-Action Banner -->
            <section class="bg-blue-600 text-white py-12 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Pre-Register Your Next Event?</h2>
                <a href="/get-started" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded shadow hover:bg-gray-100">
                Register
                </a>
            </section>
            </div>

    </body>
</html>