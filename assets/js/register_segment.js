document.querySelectorAll(".btn-register").forEach((button) => {
    button.addEventListener("click", function () {
        const segmentId = this.getAttribute("data-segment-id");
        const segmentName = this.getAttribute("data-segment-name");
        let segmentFee = this.getAttribute("data-segment-fee");

        // Handle null or missing segmentFee
        if (!segmentFee) {
            segmentFee = "Free"; // Default value if fee is not provided
        }

        // Update modal content
        document.getElementById("segmentName").textContent = segmentName;
        document.getElementById("segmentFee").textContent = segmentFee;

        // Show the modal
        const modal = document.getElementById("registerModal");
        modal.style.display = "block";

        // Handle confirmation
        document.getElementById("confirmRegister").onclick = function () {
            console.log("Attempting to register for Segment ID:", segmentId);

            // Prepare data for registration
            const registrationData = {
                segment_id: segmentId,
                regi_fee: segmentFee === "Free" ? 0 : segmentFee, // Use 0 for free segments
            };

            // Perform fetch or AJAX request here
            fetch("register_user.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(registrationData),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert("Registration successful!");
                    } else {
                        alert("Registration failed: " + data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred during registration.");
                });

            // Close the modal
            modal.style.display = "none";
        };

        // Handle cancellation
        document.getElementById("cancelRegister").onclick = function () {
            modal.style.display = "none";
        };

        // Handle close button
        document.querySelector(".close").onclick = function () {
            modal.style.display = "none";
        };

        // Close the modal if the user clicks outside of it
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    });
});
