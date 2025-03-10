$(document).ready(function() {
    // Initialize form validation
    $('#create-course-form').validate({
        rules: {
            course_name: {
                required: true,
                minlength: 5
            }
        },
        submitHandler: function(form) {
            // Collect form data
            const formData = {
                name: $('#course_name').val(),
                instructor_id: <?php echo isset($_SESSION['instructor']['id']) ? json_encode($_SESSION['instructor']['id']) : 'null'; ?>
            };

            // Perform AJAX request
            $.ajax({
                url: 'processes/create_course.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#courses-list').prepend(`
                            <div class="course-card">
                                <h4>${response.course.name}</h4>
                                <p>Enrollments: 0</p>
                                <div class="course-actions">
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>
                        `);
                    } else {
                        alert('Failed to create course.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error creating course: ' + error);
                }
            });
        }
    });
});