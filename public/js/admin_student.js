document.addEventListener('DOMContentLoaded', () => {
    next_button_average = (button) => {
        sendValueSession({'current_page': currentPage+1}, document.location = 'displayDashboard');
    }
    previous_button_average = (button) => {
        sendValueSession({'current_page': currentPage-1}, document.location = 'displayDashboard');
    }
})
