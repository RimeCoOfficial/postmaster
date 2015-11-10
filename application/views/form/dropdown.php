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

  'selected'      => set_value($id, $value),
  'options'       => $element_config['options'],

  'class'         => 'form-control',
);

$form_error = form_error($element['name']);
if (!empty($form_error)) $error[ $element['name'] ] = $form_error;
if (!empty($error[ $element['name'] ])) $element['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[ $element['name'] ])) echo 'has-error'; ?>">
  <?php echo form_label($element_config['label'], $element['id'], array('class' => 'control-label')); ?>

  <?php echo form_dropdown($element); ?>

  <?php if (!empty($error[ $element['name'] ])): ?>
    <span class="help-block"><?php echo $error[ $element['name'] ]; ?></span>
  <?php endif; ?>
</div>