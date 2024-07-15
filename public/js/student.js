if (window.location.pathname == '/ipem/landing') {
    document.addEventListener('DOMContentLoaded', () => {

        let exam_type = document.getElementById('exam_type_student');
        if (exam_type.value != 'Examen') {
            sendExam(exam_type);
        }
        exam_type.addEventListener('change', () => {
            if (exam_type.value == 'Examen') {
                $('#exam_student').hide();
                $('#exam_label_student').hide();
            } else {
                $('#exam_student').show();
                $('#exam_label_student').show();
                sendExam(exam_type);
            }
        });
    })
    
    function sendExam(exam_type) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'exam_type',
                'value': exam_type.value
            },
            success: s => {
                let parsed = JSON.parse(s);
                let exams = document.getElementById('exam_student');
                Array.from(exams.querySelectorAll('option')).forEach(element => {
                    element.remove();
                });
                parsed.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element;
                    option.textContent = element;
                    exams.appendChild(option);
                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
}
