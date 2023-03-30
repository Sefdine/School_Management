

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

$(document).ready(() => {
    let nav_left;
    let year = (document.getElementById('year')).value;
    
    resetTable = (button) => {
        sendValueSession(document.location = 'insert');
    }
    nav_left_button = (button) => {
        nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left}, 
            sendValueSession({'value': true}, document.location = 'insert')
        )
    }
    select_year = (select) => {
        console.log(select.value);
        sendValueSession({'year': select.value}, document.location = 'insert');
    }
    select_study = (select) => {
        console.log(select.value);
        sendValueSession({'study': select.value}, document.location = 'insert');
    }
    select_group = (select) => {
        console.log(select.value);
        sendValueSession({'group': select.value}, document.location = 'insert');
    }
    select_level = (select) => {
        console.log(select.value);
        sendValueSession({'level': select.value}, document.location = 'insert');
    }
});

