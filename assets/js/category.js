function editCategory(id, name, image, status) {
    // Set the values in the form fields
    $('#admin_id').val(id);
    $('#admin_name').val(name);
    $('#old_image').val(image);
    $('#status').val(status);

    // Optionally, display the current image in the modal (if any)
    if (image) {
        $('#current_image').html('<img src="<?= base_url("uploads/categories/"); ?>' + image + '" alt="Category Image" width="70" height="70">');
    } else {
        $('#current_image').html('No image available');
    }


    
}

