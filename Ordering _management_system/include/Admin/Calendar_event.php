<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar with Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>



<!-- Modal for Editing Event -->

<!-- Modal for Viewing and Editing Event -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="eventTitle"></h4>
                <p id="eventDescription"></p>
                <input type="hidden" id="eventId">
            </div>
            <div class="modal-footer">
           <!-- Dynamically assigning event ID to each Edit button -->
      
           <button type="button" class="btn btn-danger" id="edit_btn">Delete</button>

                <button type="button" class="btn btn-danger" id="deleteEvent">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Event Modal -->


    <!-- Form to Add New Event -->
    <div class="container" style="margin-top: 30px;">
        <h3>Add New Event</h3>
        <form id="eventForm" action="save_event.php" method="POST">
        <div class="form-group">
            <label for="eventTitleInput">Title</label>
            <input type="text" class="form-control" id="eventTitleInput" name="title" placeholder="Enter event title" required style="width:30%;">
        </div>
        <div class="form-group">
            <label for="eventDescriptionInput">Description</label>
            <textarea class="form-control" id="eventDescriptionInput" name="description" rows="3" placeholder="Enter event description" required style="width:30%;"></textarea>
        </div>
        <div class="form-group">
            <label for="startDateInput">Start Date</label>
            <input type="date" class="form-control" id="startDateInput" name="start_date" required style="width:30%;">
        </div>
        <div class="form-group">
            <label for="endDateInput">End Date</label>
            <input type="date" class="form-control" id="endDateInput" name="end_date" required style="width:30%;">
        </div>
        <button type="submit" class="btn btn-success mt-3">Save Event</button>
    </form>

</div>

<!-- FullCalendar Container -->
<div class="box" style="margin-top: -30%; margin-left:30%">
<div id="calendar" style="width: 50%; margin: 40px auto; background:#fff"></div>

</div>

     

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true, // Allow drag and drop
            events: 'fetch_event.php', // Fetch events from the backend
            eventClick: function (info) {
                const eventId = info.event.id; // Unique ID from database
                const eventTitle = info.event.title;

                // Prompt for Edit or Delete
              
                  
                 if (confirm(`Do you want to delete "${eventTitle}"?`)) {
                    if (confirm("Are you sure? This action cannot be undone.")) {
                        $.ajax({
                            url: 'delete_event.php',    
                            type: 'POST',
                            data: { id: eventId },
                            success: function (response) {
                                alert(response);
                                calendar.refetchEvents(); // Refresh events on the calendar
                            }
                        });
                    }
                }
            }
        });

        calendar.render();
    });
</script>
    </script>

<!-- Bootstrap JS -->


</body>
</html>

<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>
