<?php ob_start(); ?>
<div class="mt-3 d-flex mx-5">
    <div class="ms-3 dashboard_icon">
        <i class="fa-solid fa-gauge"></i>
        <label class="dashboard_text ms-1">Dashboard</label>
    </div>
    <h2 class="ml-auto home_title">Institut Parcours et Métiers</h2>
    <div class="groupe_select d-flex ml-auto">
        <label for="groupes" class="form-label me-2">Groupes</label>
        <select name="groupes" id="groupes" class="form-select">
            <option value="1">1ère année</option>
            <option value="2">2ème année</option>
        </select>
    </div>
</div>
<div class="card p-3 container d-flex flex-row plan_number">
    <div class="individual">
        <label class="m-1">Par groupe</label>
        <div class="mt-2 d-flex ">
            <div class="ms-2 d-flex registrer_data py-3 same_size">
                <div class="registrer_data_text ms-3">
                    <p id="registrer_data_value"><?= $registrer_data ?></p>
                    <label>Inscrits</label>
                </div>
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div class="ms-2 d-flex deleted_data py-3 same_size">
                <div class="deleted_data_text ms-3">
                    <p id="deleted_data_value"><?= $deleted_data ?></p>
                    <label>Abandons</label>
                </div>
                <i class="fa-solid fa-user-minus"></i>
            </div>
        </div>
    </div>
    <div class="total">
        <label class="m-1">Total</label>
        <div class="mt-2 d-flex">
            <div class="ms-2 d-flex registrer_all py-3 same_size">
                <div class="registrer_all_text ms-3">
                    <p id="registrer_all_value"><?= $registrer_all ?></p>
                    <label>Inscrits</label>
                </div>
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="ms-2 d-flex deleted_all py-3 same_size">
                <div class="deleted_all_text ms-3">
                    <p id="deleted_all_value"><?= $deleted_all ?></p>
                    <label>Abandons</label>
                </div>
                <i class="fa-solid fa-users-slash"></i>
            </div>
        </div>
    </div>
</div>
<style>
    .home_title {
        font-weight: bolder;
    }
    .groupe_select {
        background-color:rgb(167, 73, 10);
        padding: 10px;
    }
    .groupe_select label {
        color: #fff;
    }
    .dashboard_text {
        text-decoration: underline;
    }
    .dashboard_icon i{
        color: #000;
    }
    .total {
        background-color:darkkhaki;
    }
    .individual {
        background-color:darkcyan;
    }
    .individual, .total {
        width: max-content;
        padding: 4px;
    }
    .plan_number i {
        font-size: 3.8em;
        margin-left: 40%;
        margin-top: 30px;
    }
    .same_size {
        color: #fff;
        width: 310px;
    }
    .registrer_data {
        background-color: rgb(31, 31, 136);
    }
    .same_size p{
        font-size: 2.4em;
        font-weight: bolder;
    }
    .ml-auto {
        margin-left: auto;
    }
    .deleted_data {
        background-color: rgb(129, 11, 27);
    }
    .registrer_all {
        background-color: rgb(36, 100, 20);
    }
    .deleted_all {
        background-color: rgb(114, 82, 39);
    }
</style>
<script>
    let groupes = document.getElementById('groupes');
    groupes.addEventListener('change', (event) => {
        sendGroupHome(event.target);
    });
    function sendGroupHome(select) {
        $.ajax({
            type: 'post',
            url: 'homeAdmin',
            data: {
                'select': 'group',
                'value': select.value
            },
            success: s => {
                changeValueRegistrerDeleted(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function changeValueRegistrerDeleted(s) {
        let parsed = JSON.parse(s);
        let registrer_data = parsed.registrer_data;
        let deleted_data = parsed.deleted_data;
        
        // Html paragraph
        let registrer_data_value = document.getElementById('registrer_data_value');
        let deleted_data_value = document.getElementById('deleted_data_value');
        registrer_data_value.textContent = registrer_data;
        deleted_data_value.textContent = deleted_data;
    }
</script>
<?php 
$home = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>