$('#app').on('click','#vr_approve_button',function(e){
    swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.value) {
                $('#vr_approveform').trigger('submit');
            }
        })
});

$('#app').on('click','#vr_adminedit',function(e){
    $('.hr_admin_label').hide();
    $('.hr_admin_input').show('slow');
    $('.hr_admin_input2').show('slow');
});

$('#app').on('click','#vr_admincancel',function(e){
    /* $('.hr_admin_input').find('input:text').val(''); */
    $('.hr_admin_input').hide('slow');
    $('.hr_admin_input2').hide();
    $('.hr_admin_label').show('slow');
});

$('#app').on('click','#vr_adminsave',function(e){
    $('#admin_arrange_form').trigger('submit');
});

$('#app').on('click','#vr_edit',function(e){
    $('.user_edit_label').hide();
    $('.user_edit_input').show('slow');
    $('.user_edit_input1').show('slow');   
});
$('#app').on('click','#vr_canceledit',function(e){
    $('.user_edit_input').hide('slow');
    $('.user_edit_input1').hide();
    $('.user_edit_label').show('slow');    
});
$('#app').on('click','#vr_saveedit',function(e){
    $('#vr_useredit_form').trigger('submit');
});