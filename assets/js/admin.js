function editAdmin(id, name, email, role, status, image) {
    // Populate the form fields with the existing admin data
    document.getElementById('admin_id').value = id;
    document.getElementById('admin_name').value = name;
    document.getElementById('admin_email').value = email;
    document.getElementById('admin_status').value = status;
    document.getElementById('old_image').value = image;

    // Set the role in the select dropdown based on the current role
    let roleSelect = document.getElementById('admin_role');
    // Set the role based on the value, assuming 'admin' = 1 and 'staff' = 0
    if (role == 1) {
        roleSelect.value = 'admin'; // If role is 1, select 'admin'
    } else {
        roleSelect.value = 'staff'; // If role is 0, select 'staff'
    }

    // Show the current image in the modal
    if (image) {
        // If there is an image, display it
        document.getElementById('current_image').src = base_url(image); // Replace base_url(image) with actual image URL logic
        document.getElementById('current_image_section').style.display = 'block'; // Show the image section
    } else {
        document.getElementById('current_image_section').style.display = 'none'; // Hide if no image
    }
}
