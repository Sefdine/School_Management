
const jsPDF = require('jspdf');

relevePrint = () => {
    console.log('HI');
    const doc = new jsPDF();
    const releve = document.getElementById('releve');
    doc.html(releve, {
        callback: (doc) => {
            doc.autoPrint();
            doc.output('dataurlnewwindow');
        }
    });
}