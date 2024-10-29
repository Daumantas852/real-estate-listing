document.addEventListener("DOMContentLoaded", function () {
    const floorImages = document.querySelectorAll(".Floors img");
    const roomImages = document.querySelectorAll(".Rooms img");
    const roomPanes = document.querySelectorAll(".room-pane");

    let currentFloor = null;

    // Floor selection
    floorImages.forEach(img => {
        img.addEventListener("click", function () {
            currentFloor = img.getAttribute("data-floor");

            // Hide all room panes
            roomPanes.forEach(pane => pane.style.display = "none");

            // Highlight the selected floor
            floorImages.forEach(floorImg => floorImg.classList.remove("selected-floor"));
            img.classList.add("selected-floor");
        });
    });

    // Room selection
    roomImages.forEach(roomImg => {
        roomImg.addEventListener("click", function () {
            const roomNumber = roomImg.getAttribute("data-room");

            // Hide all room panes first
            roomPanes.forEach(pane => pane.style.display = "none");

            // Show the specific room pane for the selected floor and room
            const selectedPane = document.querySelector("#floor-" + currentFloor + "-room-" + (roomNumber - 1)); // Adjust for zero-based index
            if (selectedPane) {
                selectedPane.style.display = "block";
            }
        });
    });
});
