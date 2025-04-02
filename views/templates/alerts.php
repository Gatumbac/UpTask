<?php 
use Classes\FlashMessage;

$formAlerts = $alerts ?? [];
$alertsToValidate = FlashMessage::hasMessage() ? FlashMessage::getMessage() : $formAlerts;

foreach($alertsToValidate as $type => $messages):
        foreach ($messages as $message): 
?>
            <div class="alert <?php echo $type ?>">
                <?php echo $message; ?>
            </div>
<?php   
        endforeach;
endforeach; 
?>