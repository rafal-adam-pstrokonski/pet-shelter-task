<link rel="stylesheet" href="./style/navbar.css">
<link rel="stylesheet" href="./style/footer.css">
<link rel="stylesheet" href="./style/buttons.css">
<link rel="stylesheet" href="./style/formFields.css">
<link rel="stylesheet" href="./style/mobile.css">
<link rel="stylesheet" href="./style/pet.css">
<link rel="stylesheet" href="./style/formFields.css">
<link rel="stylesheet" href="./style/general.css">
<style>
/* Mobile styles */
<?php echo file_get_contents('style/footer_desktop.css'); ?>
@media screen and (max-width: 768px) {
    .container {
        width: 100%;
        margin: 0;
    }
    .filters {
        margin: 20px 0;
        border-radius: 10px;
    }
    .pet {
        margin: 20px 0;
        border-radius: 10px;
    }
    <?php echo file_get_contents('style/footer_mobile.css'); ?>
}

</style>