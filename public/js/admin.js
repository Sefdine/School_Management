$(document).ready(() => {
    let nav_left;
    let year = (document.getElementById('year')).value;
    nav_top_a = (a) => {
        let nav_top = a.getAttribute('data-value');
        sendValueSession({'nav_top': nav_top}, '')
    }
    nav_left_button = (button) => {
        nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left, 'value': true, 'year': year}, document.location = 'displayDashboard'
        );
        if (nav_left == 'average') {
            sessionStorage.setItem('study', 1)
        } else {
            sessionStorage.setItem('study', 0)
        }
    }
    let session_study = sessionStorage.getItem('study');
    if (session_study != 1 || session_study == undefined) {
        $('#study_header').hide();
        $('#individual_insert').hide();
    }
    resetTable = (button) => {
        sendValueSession({'value': true}, document.location = 'displayDashboard');
    }
    select_year = (select) => {
        sendValueSession({'year': select.value}, document.location = 'displayDashboard');
    }
    select_study = (select) => {
        sendValueSession({'study': select.value}, '');
    }
    select_group = (select) => {
        sendValueSession({'group': select.value}, document.location = 'displayDashboard');
    }
    select_level = (select) => {
        sendValueSession({'level': select.value}, document.location = 'displayDashboard');
    }
    select_exam = (select) => {
        sendValueSession({'exam': select.value}, document.location = 'displayDashboard');
    }
    next_button_average = (button) => {
        sendValueSession({'current_page': currentPage+1}, document.location = 'displayDashboard');
    }
    previous_button_average = (button) => {
        sendValueSession({'current_page': currentPage-1}, document.location = 'displayDashboard');
    }
    select_module = (select) => {
        sendValueSession({'current_module': select.value}, document.location = 'displayDashboard');
    }
});

function sendValueSession(data, action) {
    $.ajax({
        type: 'POST',
        url: 'config/config.php',
        data: data,
        success: success => {
            action;
        },
        error: (error) => {
            console.error(error);
        }
    })
}


