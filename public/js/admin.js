
let nav_left = 'student';

    
function hideInsert() {
    $('.admin_teacher').hide();
    $('.admin_study').hide();
    $('.admin_group').hide();
    $('.admin_level').hide();
    $('.admin_average').hide();
}

nav_left_button = (button) => {
    nav_left = button.getAttribute('data-value');
    
    switch (nav_left) {
        case 'student':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_student').show();
            break;
        case 'teacher':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_teacher').show();
            break;
        case 'study':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_study').show();
            break;
        case 'group':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_group').show();
            break;
        case 'level':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_level').show();
            break;
        case 'average':
            hideInsert();
            $('.admin_student').hide();
            $('.admin_average').show();
            break;
        default:
            hideInsert();
            $('.admin_student').hide();
            $('.admin_student').show();
            break;
    }
}

$(document).ready(() => {
    hideInsert();
})