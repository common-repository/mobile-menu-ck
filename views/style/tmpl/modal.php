<?php
Namespace Mobilemenuck;
defined('CK_LOADED') or die;
?>
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckframework.css" type="text/css" />
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/admin.css" type="text/css" />
<?php
echo Helper::renderProMessage();
echo MobilemenuckHelper::copyright();