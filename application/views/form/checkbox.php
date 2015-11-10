<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (empty($value)) $value = NULL;

$this->load->config('form_element', TRUE);
$element_config = $this->config->item($id, 'form_element');

$element = array(
  'name'          => $id,
  'id'            => $id,
  'value'         => '1',
  'checked'       => set_value($id, $value),
);
$element_empty = array(
  'name'          => $id,
  'id'            => $id.'_empty',
  'value'         => '0',
  'type'          => 'hidden',
);
?>

<div class="checkbox">
  <label class="full-width control-label">

    <?php echo form_checkbox($element_empty); ?>
    <?php echo form_checkbox($element); ?>

    <?php echo $element_config['label']; ?>
  
  </label>
</div>