$(document).ready(() => {
let year = document.getElementById('year_single');
if (year.value) {
    sendValueSelect('year', year.value, 'study_single');
}
year.addEventListener('change', () => {
    sendValueSelect('year', year.value, 'study_single');
})

let study = document.getElementById('study_single');
if (study.firstChild) {
    setTimeout(() => {
        sendStudy(study);
    }, 10);
    sendStudy(study);
}
study.addEventListener('change', () => {
    sendStudy(study);
})

let exam_type = document.getElementById('exam_type_single');
if (exam_type.value) {
    sendValueSelect('exam_type', exam_type.value, 'exam_single');
}
exam_type.addEventListener('change', () => {
    sendValueSelect('exam_type', exam_type.value, 'exam_single');
})
});

function sendValueSelect (select, value, id) {
    $.ajax({
        type: 'post',
        url: 'ajax',
        data: {
            'select': select,
            'value': value
        },
        success: s => {
            let parsed = JSON.parse(s);
            let studies = document.getElementById(id);
            Array.from(studies.querySelectorAll('option')).forEach(item => {
                item.remove();
            })
            parsed.forEach(element => {
                let option = document.createElement('option');
                option.value = element;
                option.textContent = element;
                studies.appendChild(option); 
            });
        },
        error: (xhr, textStatus, errorThrown) => {
            console.error(errorThrown);
        }
    })
}

function sendStudy (study) {
    $.ajax({
        type: 'post',
        url: 'ajax',
        data: {
            'select': 'study',
            'value': study.value
        },
        dataType: 'json',
        success: s => {
            let groupes = document.getElementById('group_single');
            Array.from(groupes.querySelectorAll('option')).forEach(item => {
                item.remove();
            })
            s.forEach(element => {
                let option = document.createElement('option');
                option.value = element;
                option.textContent = (element == 1) ? '1ère année' : '2ème année';
                groupes.appendChild(option);
            });
        },
        error: (xhr, textStatus, errorThrown) => {
            console.error(errorThrown);
        }
    })
}