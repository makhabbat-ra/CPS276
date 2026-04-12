<?php
require_once 'classes/Validation.php';

class StickyForm extends Validation {

    public function validateForm($data, $formConfig) {

        if (!isset($formConfig['masterStatus'])) {
            $formConfig['masterStatus'] = ['error' => false];
        }

        foreach ($formConfig as $key => &$element) {

            if ($key === 'masterStatus') continue;

            $element['value'] = $data[$key] ?? '';

            $customErrorMsg = $element['errorMsg'] ?? null;

        
            if (isset($element['type']) &&
                in_array($element['type'], ['text', 'textarea', 'password']) &&
                isset($element['regex'])) {

                if ($element['required'] && empty($element['value'])) {
                    $element['error'] = $customErrorMsg ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }

                elseif (!empty($element['value'])) {
                    $isValid = $this->checkFormat($element['value'], $element['regex'], $customErrorMsg);

                    if (!$isValid) {
                        $errors = $this->getErrors();
                        $element['error'] = $errors[$element['regex']] ?? 'Invalid format.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }
            }

           
            elseif (isset($element['type']) && $element['type'] === 'select') {
                $element['selected'] = $data[$key] ?? '';

                if ($element['required'] &&
                    ($element['selected'] === '0' || empty($element['selected']))) {

                    $element['error'] = $customErrorMsg ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }
            }

    
            elseif (isset($element['type']) && $element['type'] === 'checkbox') {

                if (isset($element['options'])) {
                    $anyChecked = false;

                    foreach ($element['options'] as &$option) {
                        $option['checked'] = in_array($option['value'], $data[$key] ?? []);
                        if ($option['checked']) $anyChecked = true;
                    }

                    if ($element['required'] && !$anyChecked) {
                        $element['error'] = $customErrorMsg ?? 'This field is required.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }

                else {
                    $element['checked'] = isset($data[$key]);

                    if ($element['required'] && !$element['checked']) {
                        $element['error'] = $customErrorMsg ?? 'This field is required.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }
            }

            
            elseif (isset($element['type']) && $element['type'] === 'radio') {
                $isChecked = false;

                foreach ($element['options'] as &$option) {
                    $option['checked'] = ($option['value'] === ($data[$key] ?? ''));
                    if ($option['checked']) $isChecked = true;
                }

                if ($element['required'] && !$isChecked) {
                    $element['error'] = $customErrorMsg ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }
            }
        }

        return $formConfig;
    }



    private function renderError($element) {
        return !empty($element['error'])
            ? "<span class=\"text-danger\">{$element['error']}</span><br>"
            : '';
    }

    public function renderInput($element, $class = '') {
    $errorOutput = $this->renderError($element);
    return <<<HTML
<div class="$class">
    <label for="{$element['id']}"><span class="text-dark">*</span> {$element['label']}</label>
    <input type="text" class="form-control" id="{$element['id']}" 
           name="{$element['name']}" value="{$element['value']}">
    $errorOutput
</div>
HTML;
}


    public function renderPassword($element, $class = '') {
    $errorOutput = $this->renderError($element);
    return <<<HTML
<div class="$class">
    <label for="{$element['id']}"><span class="text-dark">*</span> {$element['label']}</label>
    <input type="password" class="form-control" id="{$element['id']}" 
           name="{$element['name']}" value="{$element['value']}">
    $errorOutput
</div>
HTML;
}

    public function renderTextarea($element, $class = '') {
    $errorOutput = $this->renderError($element);
    return <<<HTML
<div class="$class">
    <label for="{$element['id']}"><span class="text-dark">*</span> {$element['label']}</label>
    <textarea class="form-control" id="{$element['id']}" 
              name="{$element['name']}">{$element['value']}</textarea>
    $errorOutput
</div>
HTML;
}


}
?>