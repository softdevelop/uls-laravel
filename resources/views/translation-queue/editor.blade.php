<div class="p-20" ng-init="translation = {{$translation}}">
    <center> <h3>{{ trans('configuration/translation-quece/editor.translation_editor') }}</h3> </center>
    <div ng-show="error">@{{error}}</div>

    <form role="form" name="editTranslate_form" method="GET" action="/api/translation-queue/export" novalidate>
    <div>
        <span class="button pull-left" ng-model="translation.file"
                      ngf-select
                      ngf-reset-on-click="false"
                      ngf-accept="'application/vnd.ms-excel'"
                      accept="application/vnd.ms-excel"
                      ngf-change="upload(translation.file)">
                      {{ trans('configuration/translation-quece/editor.import') }}
        </span>
        <button class="button pull-right" ng-model="translation.export">{{ trans('configuration/translation-quece/editor.export') }}</button>
    </div>

    <div class="clearfix"></div>

        <center>
            <label for="">{{ trans('configuration/translation-quece/editor.page') }}: <a>@{{translation.page.url}}</a></label><br>
            <label for="">{{ trans('configuration/translation-quece/editor.english_to') }} @{{translation.language.name}}</label>
        </center>

        <label for=""><strong>{{ trans('configuration/translation-quece/editor.meta') }}:<span class="text-require"> *</span>:</strong> @{{translation.page.meta}}</label> <br>
        <input type="text"  class="form-control" placeholder = "Meta translation"
                ng-model="translation.meta"
                name="meta_translation"
                ng-required = "true"><br>
        <div class="pull-right">
            <small class="error" ng-show="submitted && editTranslate_form.meta_translation.$error.required">{{ trans('configuration/translation-quece/editor.meta_required') }}.</small>
        </div>

        <label for=""><strong>{{ trans('configuration/translation-quece/editor.title') }}:<span class="text-require"> *</span>:</strong> @{{translation.page.title}}</label> <br>
        <input type="text"  class="form-control" placeholder = "Title translation"
                ng-model="translation.title"
                name="title_translation"
                ng-required = "true"><br>
        <div class="pull-right">
            <small class="error" ng-show="submitted && editTranslate_form.title_translation.$error.required">{{ trans('configuration/translation-quece/editor.title_required') }}</small>
        </div>

        <label for=""><strong>{{ trans('configuration/translation-quece/editor.heading') }}:<span class="text-require"> *</span>:</strong> @{{translation.page.heading}}</label> <br>
        <input type="text"  class="form-control" placeholder = "Heading translation"
                ng-model="translation.heading"
                name="heading_translation"
                ng-required = "true"><br>
        <div class="pull-right">
            <small class="error" ng-show="submitted && editTranslate_form.heading_translation.$error.required">{{ trans('configuration/translation-quece/editor.heading_required') }}</small>
        </div>

        <label for=""><strong>{{ trans('configuration/translation-quece/editor.subheading') }}:<span class="text-require"> *</span>:</strong> @{{translation.page.subHeading}}</label> <br>
        <input type="text"  class="form-control" placeholder = "Subheading translation"
                ng-model="translation.subheading"
                name="subheading_translation"
                ng-required = "true"><br>
        <div class="pull-right">
            <small class="error" ng-show="submitted && editTranslate_form.subheading_translation.$error.required">{{ trans('configuration/translation-quece/editor.subheading_required') }}</small>
        </div>

        <label for=""><strong>{{ trans('configuration/translation-quece/editor.description') }}:</strong></label>
        <label ng-bind-html = "translation.page.description"></label><br>

        <textarea class="form-control" placeholder = "Description translation"
                    ng-model="translation.description"
                    name="description_translation"></textarea>

        {{-- <textarea name="description" class="form-controller" id="summernote" cols="30" rows="10"
                    ng-model='translation.description' value = "a">
        </textarea> --}}

    </form>
<br>
<div>
    <button class="btn btn-primary" ng-click="submit(editTranslate_form.$invalid)">{{ trans('configuration/translation-quece/editor.submit') }}</button>
    <button class="btn btn-warning" ng-click="cancel()">{{ trans('configuration/translation-quece/editor.cancel') }}</button>

</div>

</div>

<script>
    // $('#summernote').summernote({height: 100});
</script>
