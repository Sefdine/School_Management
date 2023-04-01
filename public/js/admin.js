$(document).ready(() => {
    let nav_left;
    let year = (document.getElementById('year')).value;
    nav_left_button = (button) => {
        nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left, 'value': true, 'year': year}, document.location = 'insert'
        );
        if (nav_left == 'average') {
            sessionStorage.setItem('study', 1)
        } else {
            sessionStorage.setItem('study', 0)
        }
    }
    let session_study = sessionStorage.getItem('study');
    console.log(session_study)
    if (session_study != 1 || session_study == undefined) {
        $('#study_header').hide();
    }
    resetTable = (button) => {
        sendValueSession({'value': true}, document.location = 'insert');
    }
    select_year = (select) => {
        sendValueSession({'year': select.value}, document.location = 'insert');
    }
    select_study = (select) => {
        sendValueSession({'study': select.value}, document.location = 'insert');
    }
    select_group = (select) => {
        sendValueSession({'group': select.value}, document.location = 'insert');
    }
    select_level = (select) => {
        sendValueSession({'level': select.value}, document.location = 'insert');
    }
    select_exam = (select) => {
        sendValueSession({'exam': select.value}, document.location = 'insert');
    }
    next_button_average = (button) => {
        sendValueSession({'current_page': currentPage+1}, document.location = 'insert');
    }
    previous_button_average = (button) => {
        sendValueSession({'current_page': currentPage-1}, document.location = 'insert');
    }
    select_module = (select) => {
        sendValueSession({'current_module': select.value}, document.location = 'insert');
    }
});

function sendValueSession(data, action) {
    $.ajax({
        type: 'POST',
        url: 'config/config.php',
        data: data,
        success: () => {
            action;
        },
        error: (error) => {
            console.error(error);
        }
    })
}



