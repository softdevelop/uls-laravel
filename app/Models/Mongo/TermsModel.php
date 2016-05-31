<?php namespace App\Models\Mongo;

use Former\Facades\Former;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use Rowboat\FormBuilder\Models\Mongo\FiledTypeMongo;
use Rowboat\FormBuilder\Services\DirectiveService;
use Rowboat\FormBuilder\Services\FieldTypeService;
use Rowboat\FormBuilder\Services\FormBuilderService;

class TermsModel extends Eloquent
{

    protected $collection = 'terms';
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'ngModel', 'description', 'help', 'ticket'];

    public function fields()
    {
        return $this->embedsMany('App\Models\Mongo\Fields');
    }

    public function getTerms()
    {
        return $this->all();
    }
    /**
     * [store description]
     * @return [type] [description]
     * store data option
     */
    public function store($data)
    {

        $data['ngModel'] = str_replace(" ", "_", strtolower($data['name']));

        $status = $this->create($data);

        return $status;

    }
    public function updateTerm($data)
    {

        $data['ngModel'] = str_replace(" ", "_", strtolower($data['name']));

        $this->update($data);

        return $this;

    }
    public function ticketTerm()
    {
        $term = TermsModel::where('ticket', true)->get();
        return $term;

    }
    public function showHtmlField($data)
    {
        $field = FieldMongo::find($data['field_id']);

        if (!empty($field->term) && $field->term) {

            $data['term'] = true;

            $data['modal'] = false;

        }

        unset($data['id']);

        $data['orveride_filed'] = false;

        $fieldType = FiledTypeMongo::find($field->field_type_id);

        if (!empty($fieldType)) {

            foreach ($fieldType['attribute'] as $key => $value) {

                if ($value['key'] == 'upload-file') {

                    $data['orveride_filed'] = true;

                    break;
                }
            }

        }

        $this->fields()->create($data);

        if (!empty($field->term) && $field->term) {

            $htmlField = $field->viewFieldTerm();

        } else {

            $htmlField = $field->viewField($this->name)['html'];
        }

        $field = $this->fields()->latest()->first()->toArray();

        return ['htmlField' => $htmlField, 'value' => $field];
    }

    public function viewHtmlFieldInCurrentTerm($term = false)
    {
        $htmlOrverideFiled = [];

        $viewFile = [];

        foreach ($this->fields->toArray() as $key => $value) {

            $field = FieldMongo::find($value['field_id']);

            $htmlOrverideFiled[$key]['attrName'] = $field->ngModel;

            if ($this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray()) {

                $value['postWrapperHtml'] = $this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray();
            }
            $htmlOrverideFiled[$key]['value'] = $value;

            $htmlOrverideFiled[$key]['value']['alias'] = $field->ngModel . '_' . $key;

            $htmlOrverideFiled[$key]['name'] = $field->name;

            if (empty($value['col'])) {
                $htmlOrverideFiled[$key]['value']['col'] = 12;
            }

            if (!empty($value['term']) && $value['term']) {
                /* If field of term is override and isset value col then set css for field of term */
                if ($value['orveride_filed'] && isset($value['col'])) {

                    $htmlOrverideFiled[$key]['htmlField'] = "<div class='col-md-" . $value['col'] . "'>" . $field->viewFieldTerm() . '</div>';

                } else {

                    $htmlOrverideFiled[$key]['htmlField'] = $field->viewFieldTerm();
                }

                $fieldTypeIsMulti = FiledTypeMongo::find($field->field_type_id);

                if (!empty($fieldTypeIsMulti) && isset($fieldTypeIsMulti->isMulti)) {

                    $htmlOrverideFiled[$key]['value']['isMulti'] = $fieldTypeIsMulti->isMulti;

                } else {

                    $htmlOrverideFiled[$key]['value']['isMulti'] = false;
                }

            } else {

                $idOption = null;

                $countHtml = count($field->html_attributes);

                if (!empty($field->field_type_id)) {

                    $outputType = $field->field_type_id;

                    $fieldType = FiledTypeMongo::find($field->field_type_id);

                    $html_attributes = $field->html_attributes;

                    if (!empty($fieldType)) {

                        $outputType = $fieldType->output_type;

                        foreach ($fieldType->attribute as $key1 => $value1) {

                            if ($value1['value'] === '*' || $value1['value'] === '&') {
                                continue;
                            }

                            $html_attributes[$countHtml] = $value1;

                            $countHtml++;
                        }
                    }

                }

                $field->html_attributes = $html_attributes;

                $htmlOrverideFiled[$key]['fieldId'] = $value['_id'];

                if ($value['orveride_filed']) {

                    $atrtibutes = [];

                    $addonPre = '';

                    $addonPost = '';

                    $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($this->name))) . '.' . $field->ngModel;

                    if ($term) {

                        $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($term))) . '.' . $field->ngModel;
                    }

                    $field->html_attributes = DirectiveService::getDirectiveOfFieldType($field->html_attributes);

                    foreach ($field->html_attributes as $index => $item) {

                        if ($item['key'] == 'option') {

                            $idOption = $item['value'];

                        } else {

                            if (!empty($value['placeholder']) && $item['key'] == 'placeholder') {

                            } else {

                                if ($item['key'] == 'upload-file' && $term) {

                                    $atrtibutes['is-upload-serve'] = 1;
                                }

                                $atrtibutes[$item['key']] = $item['value'];

                            }
                        }

                        if ($item['key'] === 'type') {

                            $type = $item['value'];
                        }

                        if ($item['key'] === 'datepicker-popup' && $outputType == 'date') {
                            $type = 'text';
                        }

                        if ($item['key'] === 'name') {
                            $htmlOrverideFiled[$key]['attrName'] = $item['value'];
                        }

                        if ($item['key'] === 'text' && $outputType == 'label') {
                            $label = $item['value'];
                        }

                    }

                    $icon = '<i class="#iconGlyphicon#"></i>';

                    if (!empty($field['pre_addon']['html'])) {

                        $addonPre = $field['pre_addon']['html'];
                    }

                    if (!empty($field['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $field['pre_addon']['glyphicon'], $icon);

                    }
                    if (!empty($field['post_addon']['html'])) {

                        $addonPost = $field['post_addon']['html'];

                    }
                    if (!empty($field['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $field['post_addon']['glyphicon'], $icon);

                    }

                    if (!empty($value['placeholder'])) {

                        $atrtibutes['placeholder'] = $value['placeholder'];
                    }

                    if (!empty($value['pre_addon']['html'])) {

                        $addonPre = $value['pre_addon']['html'];

                    }

                    if (!empty($value['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $value['pre_addon']['glyphicon'], $icon);
                    }

                    if (!empty($value['post_addon']['html'])) {

                        $addonPost = $value['post_addon']['html'];
                    }

                    if (!empty($value['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $value['post_addon']['glyphicon'], $icon);
                    }

                    switch ($outputType) {
                        case 'radio':
                        case 'checkbox':

                            $form = Former::$outputType()->inline()->setAttributes($atrtibutes);

                            break;
                        case 'label':

                            $form = Former::$outputType($field->name)->setAttributes($atrtibutes);

                            break;
                        case 'select':
                            $placeholder = [];

                            if (!empty($value['placeholder'])) {

                                $placeholder = ['' => $value['placeholder']];
                            }
                            $form = Former::select()->fromQuery(array_merge($placeholder, getselectInCurrentDataOption($idOption)))->setAttributes($atrtibutes);

                            break;
                        case 'asset':
                            $form = FieldTypeService::getHtmlFieldTypeAsset($atrtibutes, $key);
                            break;
                        default:

                            if (!empty($type)) {
                                $form = Former::$type()->setAttributes($atrtibutes);
                            } else {
                                $form = Former::$outputType()->setAttributes($atrtibutes);
                            }

                            break;
                    }
                    if (!isset($value['preWrapperHtml'])) {
                        $value['preWrapperHtml'] = '';
                    }

                    if (!isset($value['postWrapperHtml'])) {
                        $value['postWrapperHtml'] = '';
                    }

                    if (empty($value['col'])) {
                        $value['col'] = 12;
                    }

                    $data = ['preWrapperHtml' => $value['preWrapperHtml'], 'postWrapperHtml' => $value['postWrapperHtml'], 'addonPre' => $addonPre, 'addonPost' => $addonPost, 'form' => $form, 'col' => $value['col'], 'label' => $field->label];

                    $htmlOrverideFiled[$key]['htmlField'] = FormBuilderService::appenHtmlForm($data);

                    // $htmlOrverideFiled[$key]['value'] = $value['col'];

                } else {

                    $data = $field->viewField($this->name, $key);

                    $htmlOrverideFiled[$key]['attrName'] = $data['attrName'];

                    $htmlOrverideFiled[$key]['htmlField'] = $data['html'];
                }
            }
        }

        return $htmlOrverideFiled;
    }

    public function viewOrverideField($id)
    {
        $data = [];

        $fieldInTerm = $this->fields()->where('_id', $id)->first();

        $field = FieldMongo::find($fieldInTerm['field_id']);

        if ($fieldInTerm['orveride_filed']) {

            if (!empty($field['pre_addon']['html'])) {

                $data['pre_addon']['html'] = $field['pre_addon']['html'];
            }

            if (!empty($field['pre_addon']['glyphicon'])) {

                $data['pre_addon']['glyphicon'] = $field['pre_addon']['glyphicon'];

            }
            if (!empty($field['post_addon']['html'])) {

                $data['post_addon']['html'] = $field['post_addon']['html'];

            }
            if (!empty($field['post_addon']['glyphicon'])) {

                $data['post_addon']['glyphicon'] = $field['post_addon']['glyphicon'];

            }

            if (!empty($fieldInTerm['pre_addon']['html'])) {

                $data['pre_addon']['html'] = $fieldInTerm['pre_addon']['html'];

            }

            if (!empty($fieldInTerm['pre_addon']['glyphicon'])) {

                $data['pre_addon']['glyphicon'] = $fieldInTerm['pre_addon']['glyphicon'];
            }

            if (!empty($fieldInTerm['post_addon']['html'])) {

                $data['post_addon']['html'] = $fieldInTerm['post_addon']['html'];
            }

            if (!empty($fieldInTerm['post_addon']['glyphicon'])) {

                $data['post_addon']['glyphicon'] = $fieldInTerm['post_addon']['glyphicon'];
            }
            if (empty($fieldInTerm['col'])) {
                $data['col'] = 12;
            } else {
                $data['col'] = $fieldInTerm['col'];
            }

            $data['placeholder'] = $fieldInTerm['placeholder'];

        } else {
            $field = FieldMongo::find($fieldInTerm['field_id']);

            $data['pre_addon'] = $field->pre_addon;

            $data['post_addon'] = $field->post_addon;

            $data['col'] = 12;
        }

        return $data;
    }

    /**
     * [orverideFieldTerm description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function orverideFieldTerm($data)
    {

        $status = 0;
        $id = $data['field_id'];

        $fieldInTerm = $this->fields()->where('_id', $id)->first();

        $data['orveride_filed'] = true;

        unset($data['field_id']);

        $status = $fieldInTerm->update($data);
        return $status;
    }

    /**
     * [viewHtmlCurrentFieldInTerm description]
     * @param  [type] $field [object field]
     * @return [htmlOrverideFiled]        [html field]
     */
    public function viewHtmlCurrentFieldInTerm($field)
    {
        $atrtibutes = [];

        $htmlOrverideFiled = [];

        $fieldObject = FieldMongo::find($field['field_id']);

        $htmlOrverideFiled['value'] = $field->toArray();

        if (!empty($field->term) && $field->term) {
            /* If field of term is override and isset value col then set css for field of term */
            if ($field->orveride_filed && isset($field->col)) {

                $htmlOrverideFiled['htmlField'] = "<div class='col-md-" . $field->col . "'>" . $fieldObject->viewFieldTerm() . '</div>';

            } else {

                $htmlOrverideFiled['htmlField'] = $fieldObject->viewFieldTerm();
            }

            $fieldTypeIsMulti = FiledTypeMongo::find($fieldObject->field_type_id);

            if (!empty($fieldTypeIsMulti) && isset($fieldTypeIsMulti->isMulti)) {

                $htmlOrverideFiled['value']['isMulti'] = $fieldTypeIsMulti->isMulti;

            }

        } else {

            $fieldTypeService = new FieldTypeService();

            $outputType = $fieldObject->field_type_id;

            # get atrtibutes field type
            #
            $fieldType = FiledTypeMongo::find($outputType);

            if (!empty($fieldType)) {
                $outputType = $fieldType->output_type;
            }

            $addonPre = '';

            $addonPost = '';

            # get atrtibutes field orveride and field type

            if (!empty($fieldType)) {

                $keyAtrtibutes = array_fetch($fieldObject->html_attributes, 'key');

                $attrFieldType = $fieldTypeService->getAttributeRaw($keyAtrtibutes, $fieldObject->field_type_id);

            } else {

                $attrFieldType = [];
            }

            $html_attributes = array_merge(!empty($fieldObject->html_attributes) ? $fieldObject->html_attributes : [], $attrFieldType);

            # option pulldown
            $idOption = null;
            # type input
            $type = null;

            $label = $fieldObject->name;

            $idOption = null;

            $html_attributes = DirectiveService::getDirectiveOfFieldType($html_attributes);

            # for atrtibutes
            foreach ($html_attributes as $key => $value) {

                $strpos = strpos($value['value'], '&');

                if ($strpos === false) {
                    $strpos = strpos($value['value'], '*');
                }

                if ($strpos === 0) {
                    continue;
                }

                if ($value['key'] == 'option') {

                    $idOption = $value['value'];

                } else {
                    /* Format value for attribute */
                    $value['value'] = FormBuilderService::formatValueAttribute($value['value']);

                    $atrtibutes[$value['key']] = $value['value'];
                }

                if ($value['key'] == 'type') {
                    $type = $value['value'];
                }

                if ($value['key'] == 'datepicker-popup' && $outputType == 'date') {
                    $type = 'text';
                }

                if ($value['key'] == 'text' && $outputType == 'label') {
                    $label = $value['value'];
                }

            }

            // Orveride artibute placeholder field at to exist field placeholder in term

            if (!empty($field['placeholder'])) {

                $atrtibutes['placeholder'] = $field['placeholder'];
            }

            $icon = '<i class="#iconGlyphicon#"></i>';

            // Orveride preaddon html field

            if (!empty($fieldObject['pre_addon']['html'])) {

                $addonPre = $fieldObject['pre_addon']['html'];
            }

            if (!empty($fieldObject['pre_addon']['glyphicon'])) {

                $addonPre = $addonPre . str_replace('#iconGlyphicon#', $fieldObject['pre_addon']['glyphicon'], $icon);

            }
            if (!empty($fieldObject['post_addon']['html'])) {

                $addonPost = $fieldObject['post_addon']['html'];

            }
            if (!empty($fieldObject['post_addon']['glyphicon'])) {

                $addonPost = $addonPost . str_replace('#iconGlyphicon#', $fieldObject['post_addon']['glyphicon'], $icon);

            }

            if (!empty($field['pre_addon']['html'])) {

                $addonPre = $field['pre_addon']['html'];

            }

            // Orveride icon preaddon glyphicon field

            if (!empty($field['pre_addon']['glyphicon'])) {

                $addonPre = $addonPre . str_replace('#iconGlyphicon#', $field['pre_addon']['glyphicon'], $icon);
            }

            // Orveride postaddon html field

            if (!empty($field['post_addon']['html'])) {

                $addonPost = $field['post_addon']['html'];
            }

            // Orveride icon postaddon glyphicon field

            if (!empty($field['post_addon']['glyphicon'])) {

                $addonPost = $addonPost . str_replace('#iconGlyphicon#', $field['post_addon']['glyphicon'], $icon);
            }

            if (strpos($this->name, '-') !== false) {
                $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($this->name))) . '.' . $fieldObject->ngModel;
            }

            $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($this->name))) . '.' . $fieldObject->ngModel;

            $htmlOrverideFiled['fieldId'] = $field['_id'];

            // check field type to view form and html follow field type
            switch ($outputType) {
                case 'radio':
                case 'checkbox':

                    $form = Former::$outputType()->inline()->setAttributes($atrtibutes);

                    break;
                case 'label':

                    $form = Former::$outputType($fieldObject->name)->setAttributes($atrtibutes);

                    break;
                case 'select':
                    if (!empty($field['placeholder'])) {

                        $placeholder = ['' => $field['placeholder']];
                        $form = Former::select()->fromQuery(array_merge($placeholder, getselectInCurrentDataOption($idOption)))->setAttributes($atrtibutes);
                    } else {
                        $form = Former::select()->fromQuery(getselectInCurrentDataOption($idOption))->setAttributes($atrtibutes);
                    }

                    break;
                default:
                    if (!empty($type)) {
                        $form = Former::$type()->setAttributes($atrtibutes);
                    } else {
                        $form = Former::$outputType()->setAttributes($atrtibutes);
                    }

                    break;

                    break;
            }

            if (empty($field['col'])) {
                $field['col'] = 12;
            }

            if (!isset($field['preWrapperHtml'])) {
                $field['preWrapperHtml'] = '';
            }

            if (!isset($field['postWrapperHtml'])) {
                $field['postWrapperHtml'] = '';
            }

            $data = ['preWrapperHtml' => $field['preWrapperHtml'], 'postWrapperHtml' => $field['postWrapperHtml'], 'addonPre' => $addonPre, 'addonPost' => $addonPost, 'form' => $form, 'col' => $field['col'], 'label' => $fieldObject->label];

            $htmlOrverideFiled['htmlField'] = FormBuilderService::appenHtmlForm($data);

        }
        return $htmlOrverideFiled;
    }

/**
 * [changeFieldIsModal description]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
    public function changeFieldIsModal($data)
    {
        /* Get term */
        $term = self::find($data['termId']);

        $field = $term->fields()->where('id', $data['fieldId'])->get()->first();

        $field->modal = !$field->modal;

        $field->save();
    }

    public function viewForm()
    {
        $htmlOrverideFiled = [];

        $viewFile = [];

        foreach ($this->fields->toArray() as $key => $value) {

            $field = FieldMongo::find($value['field_id']);

            $htmlOrverideFiled[$key]['attrName'] = $field->ngModel;

            if ($this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray()) {

                $value['postWrapperHtml'] = $this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray();
            }
            $htmlOrverideFiled[$key]['value'] = $value;

            $htmlOrverideFiled[$key]['value']['alias'] = $field->ngModel . '_' . $key;

            if (empty($value['col'])) {
                $htmlOrverideFiled[$key]['value']['col'] = 12;
            }

            if (!empty($value['term']) && $value['term']) {

                $htmlOrverideFiled[$key]['attrName'] = 'term';

                if ($value['orveride_filed'] && isset($value['col'])) {

                    $htmlOrverideFiled[$key]['htmlField'] = "<div class='col-md-" . $value['col'] . "'>" . $field->viewFieldTerm(true) . '</div>';

                } else {

                    $htmlOrverideFiled[$key]['htmlField'] = $field->viewFieldTerm(true);
                }
                // $htmlOrverideFiled[$key]['htmlField'] = $field->viewFieldTerm();

                $htmlOrverideFiled[$key]['name'] = $field->name;

                $htmlOrverideFiled[$key]['fileds'] = [];

                $term = $field->fieldType->term;

                foreach ($term->fields()->toArray() as $index => $item) {

                    $fieldItem = FieldMongo::find($item['field_id']);

                    $htmlOrverideFiled[$key]['fileds'][$index]['name'] = $fieldItem->name;
                    // d($fieldItem);die;
                    if (strpos($fieldItem->name, '-') !== false) {
                        $htmlOrverideFiled[$key]['fileds'][$index]['alias'] = str_replace('-', '_', trim($fieldItem->ngModel));
                    }

                    $htmlOrverideFiled[$key]['fileds'][$index]['alias'] = str_replace(' ', '_', trim($fieldItem->ngModel));

                    $filedTypeIndex = FiledTypeMongo::find($fieldItem->field_type_id);

                    if (!empty($filedTypeIndex)) {

                        $htmlOrverideFiled[$key]['fileds'][$index]['element'] = $fieldItem->fieldType->output_type;

                    } else {

                        $htmlOrverideFiled[$key]['fileds'][$index]['element'] = $fieldItem->field_type_id;
                    }

                }

                $htmlOrverideFiled[$key]['term_name'] = $term->ngModel;

                $htmlOrverideFiled[$key]['termId'] = $term->_id;

                $fieldTypeIsMulti = FiledTypeMongo::find($field->field_type_id);

            } else {

                $idOption = null;

                $outputType = $field->field_type_id;

                $countHtml = count($field->html_attributes);

                $fieldType = FiledTypeMongo::find($field->field_type_id);

                $html_attributes = $field->html_attributes;

                if (!empty($fieldType)) {

                    $outputType = $fieldType->output_type;

                    foreach ($fieldType->attribute as $key1 => $value1) {

                        if ($value1['value'] === '*' || $value1['value'] === '&') {
                            continue;
                        }

                        $html_attributes[$countHtml] = $value1;

                        $countHtml++;
                    }
                }

                $field->html_attributes = $html_attributes;

                $htmlOrverideFiled[$key]['fieldId'] = $value['_id'];

                $htmlOrverideFiled[$key]['name'] = $field->name;

                if ($value['orveride_filed']) {

                    $atrtibutes = [];

                    $addonPre = '';

                    $addonPost = '';

                    $field->html_attributes = DirectiveService::getDirectiveOfFieldType($field->html_attributes);

                    foreach ($field->html_attributes as $index => $item) {

                        if ($item['key'] == 'option') {

                            $idOption = $item['value'];

                        } else {

                            if (!empty($value['placeholder']) && $item['key'] == 'placeholder') {

                            } else {

                                $atrtibutes[$item['key']] = $item['value'];

                            }
                        }
                        if ($item['key'] == 'type') {

                            $type = $item['value'];
                        }

                        if ($item['key'] == 'datepicker-popup' && $outputType == 'date') {
                            $type = 'text';
                        }

                        if ($item['key'] === 'name') {
                            $htmlOrverideFiled[$key]['attrName'] = $item['value'];
                        }

                        if ($item['key'] == 'text' && $outputType == 'label') {
                            $label = $item['value'];
                        }

                        if ($item['key'] == 'upload-file') {

                            $atrtibutes['is-upload-serve'] = 1;
                        }

                    }

                    $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($this->name))) . '.' . $field->ngModel;

                    if ($field->term) {

                        $atrtibutes['ng-model'] = str_replace(' ', '_', strtolower(trim($termName))) . '.' . $field->ngModel;
                    }

                    $icon = '<i class="#iconGlyphicon#"></i>';

                    if (!empty($field['pre_addon']['html'])) {

                        $addonPre = $field['pre_addon']['html'];
                    }

                    if (!empty($field['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $field['pre_addon']['glyphicon'], $icon);

                    }
                    if (!empty($field['post_addon']['html'])) {

                        $addonPost = $field['post_addon']['html'];

                    }
                    if (!empty($field['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $field['post_addon']['glyphicon'], $icon);

                    }

                    if (!empty($value['placeholder'])) {

                        $atrtibutes['placeholder'] = $value['placeholder'];
                    }

                    if (!empty($value['pre_addon']['html'])) {

                        $addonPre = $value['pre_addon']['html'];

                    }

                    if (!empty($value['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $value['pre_addon']['glyphicon'], $icon);
                    }

                    if (!empty($value['post_addon']['html'])) {

                        $addonPost = $value['post_addon']['html'];
                    }

                    if (!empty($value['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $value['post_addon']['glyphicon'], $icon);
                    }

                    switch ($outputType) {
                        case 'radio':
                        case 'checkbox':

                            $form = Former::$outputType()->inline()->setAttributes($atrtibutes);

                            break;
                        case 'label':

                            $form = Former::$outputType($field->name)->setAttributes($atrtibutes);

                            break;
                        case 'select':
                            $placeholder = [];

                            if (!empty($value['placeholder'])) {

                                $placeholder = ['' => $value['placeholder']];
                            }
                            $form = Former::select()->fromQuery(array_merge($placeholder, getselectInCurrentDataOption($idOption)))->setAttributes($atrtibutes);

                            break;
                        case 'asset':
                            $form = FieldTypeService::getHtmlFieldTypeAsset($atrtibutes, $key);
                            break;
                        default:
                            if (!empty($type)) {
                                $form = Former::$type()->setAttributes($atrtibutes);
                            } else {
                                $form = Former::$outputType()->setAttributes($atrtibutes);
                            }

                            break;

                            break;
                    }

                    if (empty($value['col'])) {
                        $value['col'] = 12;
                    }

                    $data = ['addonPre' => $addonPre, 'addonPost' => $addonPost, 'form' => $form, 'col' => $value['col'], 'label' => $field->label];

                    $htmlOrverideFiled[$key]['htmlField'] = FormBuilderService::appenHtmlForm($data);

                    // $htmlOrverideFiled[$key]['htmlField'] = $htmlOrverideFiled[$key]['htmlField'] = "<div class='padding-none col-md-" . $value->col . "'>" . $addonPre . $form . $addonPost . '</div><div class="clearfix"></div>';
                    // $htmlOrverideFiled[$key]['htmlField'] = $addonPre . $form . $addonPost;

                } else {

                    $data = $field->viewField($this->name);

                    $htmlOrverideFiled[$key]['attrName'] = $data['attrName'];

                    $htmlOrverideFiled[$key]['htmlField'] = $data['html'];

                }
            }
        }

        return $htmlOrverideFiled;
    }

    public function deleteFieldTerm($id)
    {
        $field = $this->fields()->where('_id', $id)->first();
        $dataPostWrapper = $field->postWrappers()->get();
        if (!empty($dataPostWrapper->toArray())) {
            foreach ($dataPostWrapper as $key => $value) {
                $this->fields()->find($value['startField'])->update(['endField' => '', 'preWrapperHtml' => '']);
            }

            $field->postWrappers()->delete();
        }

        if (!empty($field->endField)) {

            // $endField=$field->endField;

            $this->fields()->where('_id', $field->endField)->first()->postWrappers()->where('startField', $id)->first()->delete();

            // $endField->

        }
        $data['status'] = $field->delete();

        $data['fields'] = $this->fields();
        return $data;
    }

    public function addWrapper($_id, $data)
    {

        $status = 0;

        $status = $this->fields()->find($_id)->update(['endField' => $data['endField'], 'preWrapperHtml' => $data['preWrapperHtml']]);

        if ($status) {
            if (empty($this->fields()->find($data['endField'])->PostWrappers()->where('startField', $_id)->first())) {
                $this->fields()->find($data['endField'])->postWrappers()->create(['html' => $data['postWrapperHtml'], 'startField' => $_id]);
            } else {
                $this->fields()->find($data['endField'])->postWrappers()->where('startField', $_id)->first()->update(['html' => $data['postWrapperHtml'], 'startField' => $_id]);
            }
        }

        return $status;
    }
    public function deleteWrapper($data)
    {
        /*dd($data);die;*/
        $status = 0;
        $endField = $this->fields()->find($data['field_id'])['endField'];
        $status = $this->fields()->find($data['field_id'])->update(['endField' => '', 'preWrapperHtml' => '']);

        if ($status) {

            $this->fields()->find($endField)->postWrappers()->where('startField', $data['field_id'])->first()->delete();
        }

        return $status;
    }

    public function viewHtmlFieldTermTemplateContentManager($fieldTCM, $termName, $ngModel, $isFieldPage = true, $multiple = false)
    {
        $htmlOrverideFiled = [];

        $viewFile = [];

        $attributeName = '';

        foreach ($this->fields->toArray() as $key => $value) {

            $field = FieldMongo::find($value['field_id']);

            $htmlOrverideFiled[$key]['attrName'] = $field->ngModel;

            if ($this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray()) {

                $value['postWrapperHtml'] = $this->fields->find($value['_id'])->postWrappers()->where('fields_id', $value['_id'])->get()->toArray();
            }

            $htmlOrverideFiled[$key]['value'] = $value;

            $htmlOrverideFiled[$key]['value']['alias'] = $field->ngModel . '_' . $key;

            $htmlOrverideFiled[$key]['name'] = $field->name;

            if (empty($value['col'])) {
                $htmlOrverideFiled[$key]['value']['col'] = 12;
            }

            if (!empty($value['term']) && $value['term']) {
                /* If field of term is override and isset value col then set css for field of term */
                if ($value['orveride_filed'] && isset($value['col'])) {

                    $htmlOrverideFiled[$key]['htmlField'] = "<div class='col-md-" . $value['col'] . "'>" . $field->viewFieldTermTemplateContentManager($field) . '</div>';

                } else {

                    $htmlOrverideFiled[$key]['htmlField'] = $field->viewFieldTermTemplateContentManager($field);
                }

                $fieldTypeIsMulti = FiledTypeMongo::find($field->field_type_id);

                if (!empty($fieldTypeIsMulti) && isset($fieldTypeIsMulti->isMulti)) {

                    $htmlOrverideFiled[$key]['value']['isMulti'] = $fieldTypeIsMulti->isMulti;

                } else {

                    $htmlOrverideFiled[$key]['value']['isMulti'] = false;
                }

            } else {

                $idOption = null;

                $countHtml = count($field->html_attributes);

                if (!empty($field->field_type_id)) {

                    $outputType = $field->field_type_id;

                    $fieldType = FiledTypeMongo::find($field->field_type_id);

                    $html_attributes = $field->html_attributes;

                    if (!empty($fieldType)) {

                        $outputType = $fieldType->output_type;

                        foreach ($fieldType->attribute as $key1 => $value1) {

                            if ($value1['value'] === '*' || $value1['value'] === '&') {
                                continue;
                            }

                            $html_attributes[$countHtml] = $value1;

                            $countHtml++;
                        }
                    }

                }

                $field->html_attributes = $html_attributes;

                $htmlOrverideFiled[$key]['fieldId'] = $value['_id'];

                if ($value['orveride_filed']) {

                    $atrtibutes = [];

                    $addonPre = '';

                    $addonPost = '';

                    $currentTermName = str_replace(' ', '_', strtolower(trim($this->name)));

                    if ($fieldTCM['multiple']) {

                        $atrtibutes['ng-model'] = $ngModel . $fieldTCM['variable'] . '[field_el.key_field]' . '.' . $field->ngModel;

                    } else {

                        $atrtibutes['ng-model'] = $ngModel . $fieldTCM['variable'] . '.' . $field->ngModel;

                    }

                    if (isset($fieldTCM['required'])) {

                        $atrtibutes['required'] = ($fieldTCM['required'] === 'false') ? false : $fieldTCM['required'];
                    }

                    $field->html_attributes = DirectiveService::getDirectiveOfFieldType($field->html_attributes);

                    foreach ($field->html_attributes as $index => $item) {

                        if ($item['key'] == 'option') {

                            $idOption = $item['value'];

                        } else {

                            if (!empty($value['placeholder']) && $item['key'] == 'placeholder') {

                            } else {
                                if ($item['key'] == 'upload-file') {

                                    $atrtibutes['is-upload-serve'] = 1;
                                }
                                if ($item['key'] != 'required') {

                                    $atrtibutes[$item['key']] = $item['value'];
                                }
                                // $atrtibutes[$item['key']] = $item['value'];
                            }
                        }

                        if ($item['key'] === 'type') {

                            $type = $item['value'];
                        }

                        if ($item['key'] === 'datepicker-popup' && $outputType == 'date') {
                            $type = 'text';
                        }

                        if ($item['key'] === 'name') {

                            $attributeName = $item['value'];

                            if ($fieldTCM['multiple']) {

                                $atrtibutes[$item['key']] = $fieldTCM['variable'] . '_{{field_el.key_field}}' . '_' . $item['value'];

                            } else {

                                $atrtibutes[$item['key']] = $fieldTCM['variable'] . '.' . $item['value'];
                            }

                        }

                        if ($item['key'] === 'text' && $outputType == 'label') {
                            $label = $item['value'];
                        }

                    }

                    $icon = '<i class="#iconGlyphicon#"></i>';

                    if (!empty($field['pre_addon']['html'])) {

                        $addonPre = $field['pre_addon']['html'];
                    }

                    if (!empty($field['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $field['pre_addon']['glyphicon'], $icon);

                    }
                    if (!empty($field['post_addon']['html'])) {

                        $addonPost = $field['post_addon']['html'];

                    }
                    if (!empty($field['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $field['post_addon']['glyphicon'], $icon);

                    }

                    if (!empty($value['placeholder'])) {

                        $atrtibutes['placeholder'] = $value['placeholder'];
                    }

                    if (!empty($value['pre_addon']['html'])) {

                        $addonPre = $value['pre_addon']['html'];

                    }

                    if (!empty($value['pre_addon']['glyphicon'])) {

                        $addonPre = $addonPre . str_replace('#iconGlyphicon#', $value['pre_addon']['glyphicon'], $icon);
                    }

                    if (!empty($value['post_addon']['html'])) {

                        $addonPost = $value['post_addon']['html'];
                    }

                    if (!empty($value['post_addon']['glyphicon'])) {

                        $addonPost = $addonPost . str_replace('#iconGlyphicon#', $value['post_addon']['glyphicon'], $icon);
                    }

                    $textField = 'page';

                    if(!$isFieldPage){

                        $textField = 'block';
                    }
                    $atrtibutes['ng-change'] = 'validateCurrentForm(formData.$invalid, \'' . $textField . '\', "'. $fieldTCM['variable'] .'", ' . $field['ngModel'] . ')';

                    if(empty($atrtibutes['name']) && !empty($field)){

                        $atrtibutes['name'] = $field['ngModel'];
                    }

                    switch ($outputType) {
                        case 'radio':
                        case 'checkbox':

                            $form = Former::$outputType()->inline()->setAttributes($atrtibutes);

                            break;
                        case 'label':

                            $form = Former::$outputType($field->name)->setAttributes($atrtibutes);

                            break;
                        case 'select':
                            $placeholder = [];

                            if (!empty($value['placeholder'])) {

                                $placeholder = ['' => $value['placeholder']];
                            }
                            $form = Former::select()->fromQuery(array_merge($placeholder, getselectInCurrentDataOption($idOption)))->setAttributes($atrtibutes);

                            break;
                        case 'asset':

                            $form = FieldTypeService::getHtmlFieldTypeAsset($atrtibutes, $key);
                            break;
                        default:

                            if (!empty($type)) {
                                $form = Former::$type()->setAttributes($atrtibutes);
                            } else {
                                $form = Former::$outputType()->setAttributes($atrtibutes);
                            }

                            break;
                    }
                    if (!isset($value['preWrapperHtml'])) {

                        $value['preWrapperHtml'] = '';
                    }

                    if (!isset($value['postWrapperHtml'])) {

                        $value['postWrapperHtml'] = '';
                    }

                    if (empty($value['col'])) {
                        $value['col'] = 12;
                    }

                    $data = ['preWrapperHtml' => $value['preWrapperHtml'], 'postWrapperHtml' => $value['postWrapperHtml'], 'addonPre' => $addonPre, 'addonPost' => $addonPost, 'form' => $form, 'col' => $value['col'], 'label' => $field->label];

                    if (isset($fieldTCM['variable']) && $attributeName) {
                        $htmlOrverideFiled[$key]['htmlField'] = FormBuilderService::appenHtmlForm($data, $fieldTCM['variable'], $attributeName);
                    } else {
                        $htmlOrverideFiled[$key]['htmlField'] = FormBuilderService::appenHtmlForm($data);
                    }

                    // $htmlOrverideFiled[$key]['value'] = $value['col'];

                } else {
                    
                    $data = $field->viewFieldTemplateContentManager($fieldTCM, $this->name, $ngModel, $key, $isFieldPage, $multiple);

                    $htmlOrverideFiled[$key]['attrName'] = $data['attrName'];

                    $htmlOrverideFiled[$key]['htmlField'] = $data['html'];
                }
            }
        }

        // die;

        return $htmlOrverideFiled;
    }

}
