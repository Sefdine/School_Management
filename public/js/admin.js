
let nav_left = 'student';

    
function hideInsert() {
    $('.admin_teacher').hide();
    $('.admin_study').hide();
    $('.admin_group').hide();
    $('.admin_level').hide();
    $('.admin_average').hide();
}

function sendValueSession(action) {
    $.ajax({
        type: 'POST',
        url: 'config/config.php',
        data: {'value': true},
        success: (success) => {
            action;
        },
        error: (error) => {
            console.error(error);
        }
    })
}

function sendDataStudy() {
    let study_name = document.getElementById('study_name');
    if (!study_name.value) {
        let error = document.createElement('div');
        error.className = 'alert alert-danger text-center';
        error.textContent = 'Le filière ne peut pas etre vide';
        document.getElementById('contain_admin').appendChild(error);
    } else {
        let year = $('year').value;
        $('.alert').hide();
        $.ajax({
            type: 'POST',
            url: 'insertStudy',
            data: {
                'name': study_name,
                'year': year
            },
            success: (success) => {
                console.log('Sent succesfully');
            },
            error: (error) => {
                console.error(error);
            }
        })
    }
}

function actionStudy() {
    submit_form_study = (button) => {
        sendDataStudy();
    }    
    let admin_study = document.querySelector('.admin_study');

    admin_study.addEventListener('keydown', e => {
        if(e.key == 'Enter') {
            sendDataStudy();
        }
    });
}

$(document).ready(() => {
    hideInsert();
    resetTable = (button) => {
        sendValueSession(document.location = 'insert');
    }
    nav_left_button = (button) => {
        nav_left = button.getAttribute('data-value');
        sendValueSession();
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
    actionStudy();
})

