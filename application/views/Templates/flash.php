<?php
if ($this->session->flashdata('message')) {
    $message = $this->session->flashdata('message');
?>
    <div class="alert alert-<?php echo $message['class']; ?>">
        <button class="close" data-dismiss="alert" type="button">×</button>
        <?php echo $message['message']; ?>
    </div>
<?php
}
?>