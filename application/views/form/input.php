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
    'value'         => set_value($id, $value, FALSE), // set_value($id, $value, FALSE),
    
    'maxlength'     => !empty($element_config['max_length']) ? $element_config['max_length'] : NULL,

    'class'         => 'form-control',

    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => !empty($element_config['placeholder']) ? $element_config['placeholder'] : NULL,
    'type'          => !empty($element_config['type']) ? $element_config['type'] : 'text',
    'autocomplete'  => 'off',
);

if (!empty($element_config['required'])) $element['required'] = NULL;

$form_error = form_error($element['name']);
if (!empty($form_error)) $error[ $element['name'] ] = $form_error;
if (!empty($error[ $element['name'] ])) $element['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[ $element['name'] ])) echo 'has-error'; ?>">
    <?php echo form_label($element_config['label'].(!empty($element_config['required']) ? ' *' : ''), $element['id'], array('class' => 'control-label')); ?>
    
        <?php if (!empty($element_config['l-addon']) OR !empty($element_config['r-addon'])): ?>
            <div class="input-group">
        <?php endif; ?>
        <?php if (!empty($element_config['l-addon'])): ?>
        <span class="input-group-addon"><i class="<?php echo $element_config['l-addon']; ?>"></i></span>
        <?php endif; ?>

        <?php echo form_input($element); ?>

        <?php if (!empty($element_config['r-addon'])): ?>
        <span class="input-group-addon"><i class="<?php echo $element_config['r-addon']; ?>"></i></span>
        <?php endif; ?>
        <?php if (!empty($element_config['l-addon']) OR !empty($element_config['r-addon'])): ?>
            </div>
        <?php endif; ?>
    
    <?php if (!empty($error[ $element['name'] ])): ?>
        <p class="help-block"><?php echo $error[ $element['name'] ]; ?></p>
    <?php endif; ?>
</div>

<?php if (!empty($element_config['help'])): ?>
    <p class="help-block"><?php echo $element_config['help']; ?></p>
<?php endif; ?>
