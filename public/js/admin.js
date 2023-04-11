$(document).ready(() => {
    let nav_left;
    let year = (document.getElementById('year')).value;
    nav_top_a = (a) => {
        let nav_top = a.getAttribute('data-value');
        sendValueSession({'nav_top': nav_top}, document.location = 'displayDashboard');
        console.log(nav_top)
    }
    nav_left_button = (button) => {
        nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left, 'value': true, 'year': year},
            document.location = 'displayDashboard'
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
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'year',
                'value': select.value
            },
            dataType: 'json',
            success: s => {
                let studies = document.getElementById('study_header');
                studies.removeChild(document.querySelector('option'));
                s.forEach(element => {
                    let option = document.createElement('option');
                    option.setAttribute('value', element);
                    option.className ='text-center';
                    option.textContent = element;
                    studies.appendChild(option);
                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    select_study = (select) => {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'study',
                'study': select.value
            },
            success: s => {
                console.log(s);
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    select_group = (select) => {
        $.ajax({
            type: 'post',
            url: 'displayDashboard',
            data: {'group': select.value},
            success: s => {
                console.log(s);
                document.body.innerHTML = s;
            }, 
            error: e => {
                console.error(e);
            }
        })
    }
    select_level = (select) => {
    }
    select_exam = (select) => {
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

function sendValueSelect(data) {
    $.ajax({
        type: 'POST',
        url: 'displayDashboard',
        data: data,
        success: s => {
            console.log(s);
            document.body.innerHTML = s;
        },
        error: (error) => {
            console.error(error);
        }
    })
}

function sendValueSession(data, action) {
    $.ajax({
        type: 'POST',
        url: 'displayDashboard',
        data: data,
        success: s => {
            action;
        },
        error: (error) => {
            console.error(error);
        }
    })
}
