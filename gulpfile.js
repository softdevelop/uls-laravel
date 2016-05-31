var gulp = require('gulp');
var elixir = require('laravel-elixir');
// require('./elixir-extensions')
require('laravel-elixir-imagemin');
// require('./elixir-extensions');
// require('laravel-elixir-bower');
require('laravel-elixir-rename');
var fs        = require('fs');
var stripDebug = require('gulp-strip-debug');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.assetsPath = 'public/assets/';
elixir.config.sassDir = 'public/assets/sass'
elixir.config.cssOutput = 'public/assets/css';
elixir.config.jsOutput = 'public/assets/js';
elixir.config.baseJS = 'public/app';
elixir.config.sourcemaps = false;
require("./elixir-trip-debug")

elixir(function(mix) {
        //style template pages
    mix.sass([
        'tpl.scss',
        'themeulsinc.scss',
        'media-tpl.scss',
        ],
        elixir.config.cssOutput+'/tpl.css'
    );

    //style all pages
    mix.sass(
        [   'modules/css3-mixins.scss',
            'modules/variable.scss',
            'modules/mixins.scss',
            'modules/mixins-responsive.scss',

            'partial/breadcrumb.scss',
            'partial/button-text.scss',
            'partial/form-wizard.scss',
            'partial/loading.scss',
            
            'partial/panel.scss',
            'partial/process-bar.scss',
            'partial/progress-circle.scss',
            'partial/tab.scss',
            'partial/table.scss',
            'partial/tag-content.scss',
            'partial/toogle-switch.scss',
            'partial/tooltip.scss',
            'partial/review-and-code.scss',
            'partial/resize-bar.scss',
            'partial/show-group-action.scss',
            'partial/checkbox.scss',
            'partial/text-area.scss',
            'partial/modal.scss',

            'directive/base.scss',
            'directive/form-builder.scss',
            'directive/select-level.scss',
            'directive/tag-content.scss',

            'vendor/base.scss',
            'vendor/redactor.scss',
            'vendor/fancytree.scss',
            'vendor/select2.scss',
            'vendor/ui-sort.scss',
            'vendor/multi-select.scss',
            'vendor/ng-table.scss',
            'vendor/form-wizard-angular.scss',

            'user/base.scss',
            'user/user-group.scss',
            'user/users.scss',
            'user/profile.scss',


            'content-type/manage-term.scss',

            'content-manager/base.scss',
            'content-manager/layout.scss',
            'content-manager/asset-manager.scss',
            'content-manager/block-manager.scss',
            'content-manager/template-manager.scss',
            'content-manager/page-management.scss',
            'content-manager/database.scss',

            'site-configuration/market-segment.scss',  
            'site-configuration/channel-partners.scss',
            'site-configuration/data-option.scss',

            'ticket/base.scss',
            'ticket/create-new-task.scss',
            'ticket/index.scss',
            'ticket/your-ticket.scss',
            'ticket/type.scss',
            'ticket/details.scss',

            'help-editor/topic.scss',

            'term/field-type.scss',
            'term/create-template.scss',

            'tag-content/index.scss',

            'role/role-group.scss',

            'activity-log/index.scss',

            'seo/page-overview.scss',


            'base.scss',
            'base-responsive.scss',
            'master.scss',
            'trash.scss',

            'icon-menu.scss',
            'login.scss',
            // 'normalize.scss',
            'cms-config.scss',
            'top-navibar.scss',
            'user.scss',
            'pages-sync.scss',
            'campaign-management.scss',
            'template.scss',
            'configuration.scss',
            'dashboard.scss',
            'task-manager.scss',
            'pages.scss',
            'seo.scss',
            'terms.scss',
            'notification.scss',
            'chart.scss',
            'cropimage.scss',
            'multiselect.scss',
            'your-ticket.scss',
            'role.scss',
            'permission.scss',
            'ticket.scss',
            'crop-image.scss',
            'edit-page.scss',
            'file.scss',
            // 'fix-general.scss',
            'fix-partials.scss',
            'sidebar.scss',
            'responsive.scss',
            'search.scss'

            
        ],
        elixir.config.cssOutput+'/app.css'
    );

    //build style all pages
    baseCss = [
        'bower_components/normalize-css/normalize.css',
        'css/main.css',
        'css/rowboat/user.css',
        'css/icon/themify-icons.css',
        'css/fonts/picto.css',
        'assets/css/tpl.css',

        'assets/css/app.css',
        // 'css/label.css',
    ];
    elixir(function(mix) {
        mix.styles(baseCss, elixir.config.cssOutput+'/all.css', elixir.config.publicPath);
    });

    if(elixir.config.styles){
        return true;
    //     elixir(function(mix) {
    //     mix.version([
    //         elixir.config.cssOutput+'/all.css',
    //     ]);
    // });
        
    }
    //build page contact.js
    baseScripts = [
            'config.js',
            'app.js',
            'baseController.js',
            'components/user/userService.js',
            'components/assetmanagers/AssetManagerService.js',
            'shared/notification/notificationController.js',
            'shared/notification/notificationService.js',
            'shared/notification/notificationDirective.js',
            'shared/validate/rowboatValidateDirective.js',
            'shared/format-date/formatDate.js',
            'shared/filters/elapsedTime.js',
            'shared/translation/transFilter.js',
            'components/user/help-editor/HelpEditorDirective.js'
    ];

    elixir(function(mix) {
        mix.scripts(baseScripts, elixir.config.baseJS+'/pages/home.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/home.js');
    });

    // // // // // generate script for page contact
    elixir(function(mix) {
        libraryScripts = [
            elixir.config.publicPath+'/scripts/main.js',
            elixir.config.publicPath+'/scripts/vendor.js',
            elixir.config.publicPath+'/scripts/modernizr.js',
            elixir.config.publicPath+'/bower_components/jquery-ui/jquery-ui.min.js',
            elixir.config.publicPath+'/bower_components/jquery.maskedinput/dist/jquery.maskedinput.min.js',
            elixir.config.publicPath+'/bower_components/fancytree/dist/jquery.fancytree-all.min.js',
            elixir.config.publicPath+'/bower_components/fancytree/dist/src/jquery.fancytree.dnd.js',
            elixir.config.publicPath+'/bower_components/fancytree/dist/src/jquery.fancytree.edit.js',
            elixir.config.publicPath+'/bower_components/underscore/underscore.js',
            elixir.config.publicPath+'/bower_components/angular/angular.js',
            elixir.config.publicPath+'/bower_components/angular-resource/angular-resource.js',
            elixir.config.publicPath+'/bower_components/angular-bootstrap/ui-bootstrap.min.js',
            elixir.config.publicPath+'/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
            elixir.config.publicPath+'/bower_components/ng-table/dist/ng-table.min.js',
            elixir.config.publicPath+'/bower_components/ngImgCrop/source/js/init.js',
            elixir.config.publicPath+'/bower_components/ngImgCrop/source/js/ng-img-crop.js',
            elixir.config.publicPath+'/bower_components/ngImgCrop/compile/minified/ng-img-crop.js',
            elixir.config.publicPath+'/bower_components/pusher/dist/pusher.min.js',
            elixir.config.publicPath+'/bower_components/angular-cookies/angular-cookies.js',
            elixir.config.publicPath+'/bower_components/angular-xeditable/dist/js/xeditable.js',
            elixir.config.publicPath+'/bower_components/angular-sanitize/angular-sanitize.js',
            // elixir.config.publicPath+'/bower_components/angular/angular.min.js',
            elixir.config.publicPath+'/bower_components/moment/min/moment.min.js',
            elixir.config.publicPath+'/bower_components/moment/min/locales.min.js',
            elixir.config.publicPath+'/bower_components/humanize-duration/humanize-duration.js',
            elixir.config.publicPath+'/bower_components/angular-timer/dist/angular-timer.js',
            elixir.config.publicPath+'/bower_components/angular-ui-utils/modules/mask/mask.js',
            elixir.config.publicPath+'/bower_components/angular-animate/angular-animate.js',
            elixir.config.publicPath+'/bower_components/angular-wizard/dist/angular-wizard.min.js',
            elixir.config.publicPath+'/bower_components/ng-file-upload/ng-file-upload-shim.min.js',
            elixir.config.publicPath+'/bower_components/magnific-popup/dist/jquery.magnific-popup.js',
            elixir.config.publicPath+'/bower_components/magnific-popup/dist/jquery.magnific-popup.min.js',
            elixir.config.publicPath+'/bower_components/highcharts/highcharts.js',
            elixir.config.publicPath+'/bower_components/angular-route/angular-route.js',
            elixir.config.publicPath+'/app/shared/ng-file-upload/ng-file-upload-all.js',
            elixir.config.publicPath+'/app/lib/redactor1023/redactor/redactor.js',
            elixir.config.publicPath+'/app/lib/redactor1023/redactor/table.js',
            elixir.config.publicPath+'/app/lib/redactor1023/redactor/source.js',
            elixir.config.publicPath+'/app/lib/redactor1023/redactor/insertlink.js',
            elixir.config.publicPath+'/app/lib/redactor1023/redactor/insertpage.js',
        ];
        mix.scripts(libraryScripts, elixir.config.baseJS+'/pages/library.js', elixir.config.publicPath);
        mix.tripdebug(elixir.config.baseJS+'/pages/library.js');
    });

    /*genrate script for page asset*/
    elixir(function(mix) {
        assetScripts = [
            'app/route.js',
            'shared/resizer/resizer.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/assetmanagers/AssetManagerController.js',
            'components/assetmanagers/RequestAssetService.js',
            'components/assetmanagers/RequestAssetController.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'components/assetmanagers/UploadNewAssetDirective.js',
            'components/assetmanagers/RequestNewAssetDirective.js',
            'shared/select-multi-level/selectMultiLevelDirective.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/cms-content/cmsContentFolderService.js'
        ];
        mix.scripts(baseScripts.concat(assetScripts), elixir.config.baseJS+'/pages/asset.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/asset.js');
    });

    /*genrate script for page block*/
    elixir(function(mix) {
        blockScripts = [
            'shared/resizer/resizer.js',
            'components/blocks/BlockManagerService.js',
            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',

            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/blocks/partial/UploadNewBlockController.js',

            'shared/cms-content/cmsContentFolderService.js',
            'shared/cms-content/cmsContentInsertService.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'shared/select-level/selectLevelDirective.js',

            'shared/cms/cms-config/CmsConfigController.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'components/pages/EditDraftService.js',
            'components/assetmanagers/AssetManagerService.js',
            'shared/select-level-database/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js'
        ];
        mix.scripts(baseScripts.concat(blockScripts), elixir.config.baseJS+'/pages/block.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/block.js');
    });
    /*genrate script for page block*/
    elixir(function(mix) {
        blockScripts = [
            'components/blocks/BlockManagerService.js',
            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',
            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/blocks/manage-block/ManagerBlockValidate.js',
            'components/blocks/manage-block/ManageBlockCreate.js',
            'components/file/fileService.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/pages/EditDraftService.js',

            'shared/cms-content/cmsContentFolderService.js',
            'shared/cms-content/cmsContentInsertService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'shared/cms/cms-config/CmsConfigController.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/modal-select-level/selectLevelDirective.js',
            'shared/modal-select-page/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js',
            'shared/confirm/confirmDirective.js',
        ];
        mix.scripts(baseScripts.concat(blockScripts), elixir.config.baseJS+'/pages/block-manage.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/block-manage.js');
    });
    /*genrate script for edit block*/
    elixir(function(mix) {
        blockScripts = [
            'shared/resizer/resizer.js',
            'components/blocks/BlockManagerService.js',
            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',

            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/blocks/partial/EditBlockController.js',

            'shared/cms-content/cmsContentFolderService.js',
            'shared/cms-content/cmsContentInsertService.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'shared/select-level/selectLevelDirective.js',

            'components/pages/EditDraftService.js',
            'shared/confirm/confirmDirective.js',
            'shared/cms-content/CmsService.js',
            'shared/cms/cms-config/CmsConfigController.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'components/assetmanagers/AssetManagerService.js',
            'shared/select-level-database/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js'
        ];
        mix.scripts(baseScripts.concat(blockScripts), elixir.config.baseJS+'/pages/editBlock.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/editBlock.js');
    });


    /*genrate script for page index block*/
    elixir(function(mix) {
        blockScripts = [
            'shared/resizer/resizer.js',
            'components/blocks/BlockManagerService.js',
            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',

            'components/blocks/partial/EditBlockController.js',

            'shared/cms-content/cmsContentFolderService.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'shared/select-level/selectLevelDirective.js',
        ];
        mix.scripts(baseScripts.concat(blockScripts), elixir.config.baseJS+'/pages/index-block.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/index-block.js');
    });

    /*genrate script for page campaign manager*/
    elixir(function(mix) {
        campaignScripts = [
            'components/campaignsmanager/CampaignService.js',
            'components/campaignsmanager/CampaignController.js',
        ];
        mix.scripts(baseScripts.concat(campaignScripts), elixir.config.baseJS+'/pages/campaign.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/campaign.js');
    });

    /*genrate script for page channel partner*/
    elixir(function(mix) {
        partnerScripts = [
            'components/channelpartners/ChannelPartnersService.js',
            'components/channelpartners/ChannelPartnersController.js',
            'components/channelpartners/ChannelPartnersDirective.js',
        ];
        mix.scripts(baseScripts.concat(partnerScripts), elixir.config.baseJS+'/pages/partner.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/partner.js');
    });

    /*genrate script for page languages*/
    elixir(function(mix) {
        languageScripts = [
            'components/languages/LanguageService.js',
            'components/languages/LanguageController.js',
        ];
        mix.scripts(baseScripts.concat(languageScripts), elixir.config.baseJS+'/pages/language.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/language.js');
    });
    /*genrate script release version for page */
    elixir(function(mix) {
        languageScripts = [
            'components/pages/release-version/ReleaseVersionService.js',
            'components/pages/release-version/ReleaseVersionController.js',
        ];
        mix.scripts(baseScripts.concat(languageScripts), elixir.config.baseJS+'/pages/versions.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/versions.js');
    });
    /*genrate script for page marketsegment*/
    elixir(function(mix) {
        marketsegmentScripts = [
            'components/marketsegments/MarketSegmentService.js',
            'components/marketsegments/MarketSegmentController.js',
        ];
        mix.scripts(baseScripts.concat(marketsegmentScripts), elixir.config.baseJS+'/pages/marketsegment.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/marketsegment.js');
    });

    /*genrate script for page page*/
    elixir(function(mix) {
        pageScripts = [
            // 'app/route.js',
            'components/pages/PageService.js',
            'components/pages/PageController.js',
            'components/pages/CreatePageController.js',
            'components/pages/CreatePageService.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/assetmanagers/AssetManagerController.js',
            'components/assetmanagers/RequestAssetService.js',
            'components/assetmanagers/RequestAssetController.js',
            'components/assetmanagers/UploadNewAssetDirective.js',
            'components/template-content-manager/templateContentManagerController.js',
            'components/template-content-manager/templateContentManagerService.js',
            'components/template-content-manager/RequestNewTemplateDirective.js',
            'components/blocks/BlockManagerService.js',
            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',
            'components/blocks/partial/EditBlockController.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'components/database/DatabaseManagerService.js',
            'components/database/DatabaseManagerController.js',
            'components/file/fileService.js',
            'components/pages/CreatePageDirective.js',
            'components/assetmanagers/RequestNewAssetDirective.js',
            'shared/cms/cms-config/CmsConfigController.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'shared/tag-content-directive/tagContentDirective.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/cms-content/cmsContentFolderService.js',
            'shared/cms-content/CmsService.js',
            'shared/resizer/resizer.js',
        ];
        mix.scripts(baseScripts.concat(pageScripts), elixir.config.baseJS+'/pages/page.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/page.js');
    });
    /*genrate script for header draft*/
    elixir(function(mix) {
        pageScripts = [
           'components/pages/ViewDraftService.js',
           'components/pages/ViewDraftController.js',
        ];
        mix.scripts(baseScripts.concat(pageScripts), elixir.config.baseJS+'/pages/headerDraft.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/headerDraft.js');
    });

    /*genrate script for edit Draft */
    elixir(function(mix) {
        editDraftScripts = [
            
            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/pages/EditDraftService.js',
            'components/pages/EditDraftController.js',
            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/blocks/nested-block/BlockNestedService.js',
            'components/blocks/nested-block/BlockNestedController.js',

            'shared/format-date/CheckLimitAndChangeDateTimeDirective.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/convent-text-to-lowercase/lowercase-character.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/modal-select-page/selectLevelDirective.js',
            'shared/cms-content/cmsContentInsertService.js',
            'shared/modal-select-level/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js',
            'shared/remove-cache-front-end/removeCacheService.js',
        ];
        mix.scripts(baseScripts.concat(editDraftScripts), elixir.config.baseJS+'/pages/edit-draft.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/edit-draft.js');
    });

    /*genrate script for page page*/
    elixir(function(mix) {
        pageScripts = [
            'components/pages/EditPageService.js',
            'components/pages/EditPageController.js',
            'components/pages/EditPageDirective.js'
        ];
        mix.scripts(baseScripts.concat(pageScripts), elixir.config.baseJS+'/pages/page-edit.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/page-edit.js');
    });

    /*genrate script for page page*/
    elixir(function(mix) {
        pageScripts = [
            'components/pages/CreatePageService.js',
            'components/pages/CreatePageController.js',
            'components/pages/CreatePageDirective.js'
        ];
        mix.scripts(baseScripts.concat(pageScripts), elixir.config.baseJS+'/pages/page-create.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/page-create.js');
    });
    elixir(function(mix) {
        pageScripts = [
            'components/pages/PageService.js',
            'components/pages/PageControllerDetail.js'
        ];
        mix.scripts(baseScripts.concat(pageScripts), elixir.config.baseJS+'/pages/page-detail.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/page-detail.js');
    });
    /*genrate script for page region*/
    elixir(function(mix) {
        regionScripts = [
            'components/regions/RegionService.js',
            'components/regions/RegionController.js',
            'components/languages/LanguageService.js',
            'components/languages/LanguageController.js',
        ];
        mix.scripts(baseScripts.concat(regionScripts), elixir.config.baseJS+'/pages/region.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/region.js');
    });

    /*genrate script for page template*/
    elixir(function(mix) {
        templateScripts = [
            'components/templatemanager/TemplateManagerService.js',
            'components/templatemanager/TemplateManagerController.js',
            'shared/tag-content-directive/tagContentDirective.js'
        ];
        mix.scripts(baseScripts.concat(templateScripts), elixir.config.baseJS+'/pages/template.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/template.js');
    });
     /*genrate script for page document*/
    elixir(function(mix) {
        templateScripts = [
            'shared/resize/resizeDirective.js',
            'shared/resizer/resizer.js',
            'components/file/fileController.js',
            'components/file/fileService.js',
            'shared/file-manager/fileManagerDirective.js',
            'components/file/fileDirective.js'
        ];
        mix.scripts(baseScripts.concat(templateScripts), elixir.config.baseJS+'/pages/graphic.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/graphic.js');
    });

    /*genrate script for page template*/
    elixir(function(mix) {
        templateScripts = [
            'components/blocks/BlockManagerService.js',
            'shared/cms-content/cmsContentFolderService.js',
            'shared/cms-content/cmsContentInsertService.js',
            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/template-content-manager/templateContentManagerService.js',
            'components/template-content-manager/templateUpdateContentManagerController.js',
            'shared/confirm/confirmDirective.js',
            'shared/cms-content/CmsService.js',
            'shared/cms/cms-config/CmsConfigController.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/pages/EditDraftService.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js'
        ];
        mix.scripts(baseScripts.concat(templateScripts), elixir.config.baseJS+'/pages/templateEdit.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/templateEdit.js');
    });

    /*genrate script for page term template*/
    elixir(function(mix) {
        templateScripts = [
            'components/termTemplateManager/TermTemplateManagerService.js',
            'components/termTemplateManager/TermTemplateManagerController.js',
        ];
        mix.scripts(baseScripts.concat(templateScripts), elixir.config.baseJS+'/pages/termTemplate.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/termTemplate.js');
    });

    elixir(function(mix) {
        templateScripts = [
            'components/manage-term/ManageTermService.js',
            'components/manage-term/ManageTermController.js',
            'shared/form-builder-directive/formBuilderDirective.js'
        ];
        mix.scripts(baseScripts.concat(templateScripts), elixir.config.baseJS+'/pages/managerTerm.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/managerTerm.js');
    });

    /*genrate script for page translation*/
    elixir(function(mix) {
        translationScripts = [
            'components/translations/TranslationService.js',
            'components/translations/TranslationController.js',
        ];
        mix.scripts(baseScripts.concat(translationScripts), elixir.config.baseJS+'/pages/translation.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/translation.js');
    });

    /*genrate script for page dataoption*/
    elixir(function(mix) {
        dataoptionScripts = [
            'components/data-option/dataOptionController.js',
            'components/data-option/dataOptionService.js',
        ];
        mix.scripts(baseScripts.concat(dataoptionScripts), elixir.config.baseJS+'/pages/dataoption.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/dataoption.js');
    });

     /*genrate script for page permission*/
    elixir(function(mix) {
        permissionScripts = [
            'components/permission/permissionController.js',
            'components/permission/permissionEditorController.js',
            'components/permission/peruserController.js',
            'components/permission/peruserService.js',
            'components/permission/permissionService.js',
        ];
        mix.scripts(baseScripts.concat(permissionScripts), elixir.config.baseJS+'/pages/permission.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/permission.js');
    });

    /*genrate script for page permissionEditor*/
    elixir(function(mix) {
        permissionEditorScripts = [
            'components/permission/permissionController.js',
            'components/permission/permissionService.js',
            'components/permission/permissionDirective.js',
            'components/permission/peruserController.js',
            'components/permission/peruserService.js',
            'shared/search/searchDirective.js',
        ];
        mix.scripts(baseScripts.concat(permissionEditorScripts), elixir.config.baseJS+'/pages/permissionEditor.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/permissionEditor.js');
    });

   /*genrate script for page role*/
    elixir(function(mix) {
        roleScripts = [
            'components/role/roleController.js',
            'components/role/roleEditorController.js',
            'components/role/roleuserController.js',
            'components/role/roleuserService.js',
            'components/role/roleService.js',
        ];
        mix.scripts(baseScripts.concat(roleScripts), elixir.config.baseJS+'/pages/role.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/role.js');
    });

    /*genrate script for page roleEditor*/
    elixir(function(mix) {
        roleEditorScripts = [
            'components/role/roleEditorController.js',
            'components/role/roleService.js',
            'components/role/roleDirective.js',
            'components/role/roleuserController.js',
            'components/role/roleuserService.js',
            'shared/search/searchDirective.js'
        ];
        mix.scripts(baseScripts.concat(roleEditorScripts), elixir.config.baseJS+'/pages/roleEditor.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/roleEditor.js');
    });

    /*genrate script for page roleGroup*/
    elixir(function(mix) {
        roleGroupScripts = [
            'components/role/roleGroupController.js',
            'components/role/roleGroupService.js',
            'shared/search/searchDirective.js'
        ];
        mix.scripts(baseScripts.concat(roleGroupScripts), elixir.config.baseJS+'/pages/roleGroup.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/roleGroup.js');
    });

    /*genrate script for page ticket*/
    elixir(function(mix) {
        ticketScripts = [
            'components/ticket/ticketController.js',
            'components/ticket/ticketService.js',
            'components/file/fileController.js',
            'components/file/fileService.js',
            'shared/file/fileDirective.js',
            'components/user/userService.js',
            'shared/status/statusDirective.js',
            'shared/select-menu/selectMenuDirective.js',
        ];
        mix.scripts(baseScripts.concat(ticketScripts), elixir.config.baseJS+'/pages/ticket.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/ticket.js');
    });

    /*genrate script for page create ticket*/
    elixir(function(mix) {
        createticketScripts = [
            'components/ticket/ticketCreateController.js',
            'components/ticket/ticketService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'components/file/fileService.js',
            'components/user/userService.js',
        ];
        mix.scripts(baseScripts.concat(createticketScripts), elixir.config.baseJS+'/pages/createticket.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/createticket.js');
    });

    /*genrate script for page report*/
    elixir(function(mix) {
        reportScripts = [
            'components/ticket/ticketControllerReport.js',
            'components/ticket/ticketService.js',
            'components/file/fileService.js',
            'components/user/userService.js',
        ];
        mix.scripts(baseScripts.concat(reportScripts), elixir.config.baseJS+'/pages/report.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/report.js');
    });

    /*genrate script for page viewticket*/
    elixir(function(mix) {
        viewticketScripts = [
            'components/ticket/ticketController.js',
            'components/ticket/ticketControllerDetail.js',
            'components/ticket/ticketService.js',
            'shared/comments/commentsDirective.js',
            'shared/assign/choosePeopleDirective.js',
            'shared/invite/inviteDirective.js',
            'components/file/fileController.js',
            'components/file/fileService.js',
            'shared/file/fileDirective.js',
            'components/user/userService.js',
            'shared/search/searchDirective.js',
            'shared/customFormatDate/formatDate.js',
            'components/scenario-request/scenarioRequestDirective.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'shared/select-menu/selectMenuDirective.js'
        ];
        mix.scripts(baseScripts.concat(viewticketScripts), elixir.config.baseJS+'/pages/viewticket.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/viewticket.js');
    });

    /*genrate script for page users*/
    elixir(function(mix) {
        userScripts = [
            'components/user/userController.js',
            'components/user/userService.js',
        ];
        mix.scripts(baseScripts.concat(userScripts), elixir.config.baseJS+'/pages/user.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/user.js');
    });
    /*genrate script for page help editor*/
    elixir(function(mix) {
        helpeditorScripts = [
            'shared/resizer/resizer.js',
            'components/user/help-editor/HelpEditorService.js',
            'components/user/help-editor/HelpEditorController.js',
            'components/user/help-editor/partial/HelpEditorCreateTopic.js'
        ];
        mix.scripts(baseScripts.concat(helpeditorScripts), elixir.config.baseJS+'/pages/help-editor.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/help-editor.js');
    });

    /*genrate script for page help editor*/
    elixir(function(mix) {
        helpeditorScripts = [
            'components/user/help-editor/HelpEditorService.js',
            'components/user/help-editor/HelpEditorController.js',
            'components/user/help-editor/SelectLevelHelp.js'
        ];
        mix.scripts(baseScripts.concat(helpeditorScripts), elixir.config.baseJS+'/pages/create-help-editor.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/create-help-editor.js');
    });

    /*genrate script for page permissionforuser*/
    elixir(function(mix) {
        permissionforuserScripts = [
            'components/user/userController.js',
            'components/user/userService.js',
            'shared/multi-select/multiSelectDirective.js',
        ];
        mix.scripts(baseScripts.concat(permissionforuserScripts), elixir.config.baseJS+'/pages/permissionforuser.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/permissionforuser.js');
    });

    /*genrate script for page profile*/
    elixir(function(mix) {
        profileScripts = [
            'components/user/profileUserController.js',
            'components/user/userService.js',
        ];
        mix.scripts(baseScripts.concat(profileScripts), elixir.config.baseJS+'/pages/profile.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/profile.js');
    });

    /*genrate script for page type*/
    elixir(function(mix) {
        typeScripts = [
            'components/type/typeController.js',
            'components/type/typeService.js',
        ];
        mix.scripts(baseScripts.concat(typeScripts), elixir.config.baseJS+'/pages/type.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/type.js');
    });

    /*genrate script for page dashboard*/
    elixir(function(mix) {
        typeScripts = [
            'components/dashboard/google-chart.js',
            'components/dashboard/dashboardController.js',
            'components/dashboard/dashboardService.js',
        ];
        mix.scripts(baseScripts.concat(typeScripts), elixir.config.baseJS+'/pages/dashboard.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/dashboard.js');
    });

    /*genrate script for page term*/
    elixir(function(mix) {
        termScripts = [
            'components/terms/termController.js',
            'components/terms/termService.js'
        ];
        mix.scripts(baseScripts.concat(termScripts), elixir.config.baseJS+'/pages/terms.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/terms.js');
    });

    /*genrate script for page termDetail*/
    elixir(function(mix) {
        termDetailScripts = [
            'components/terms/termDetailController.js',
            'components/terms/termService.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/select-level/selectLevelDirective.js',
        ];
        mix.scripts(baseScripts.concat(termDetailScripts), elixir.config.baseJS+'/pages/termDetail.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/termDetail.js');
    });

    /*genrate script for page field*/
    elixir(function(mix) {
        fieldScripts = [
            'components/field/FieldController.js',
            'components/field/FieldService.js',
            'components/field-type/filedTypeService.js'
        ];
        mix.scripts(baseScripts.concat(fieldScripts), elixir.config.baseJS+'/pages/field.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/field.js');
    });

    /*genrate script for page field-type*/
    elixir(function(mix) {
        fieldTypeScripts = [
            'components/field-type/filedTypeController.js',
            'components/field-type/filedTypeService.js'
        ];
        mix.scripts(baseScripts.concat(fieldTypeScripts), elixir.config.baseJS+'/pages/field-type.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/field-type.js');
    });

    /*genrate script for page test-field-type*/
    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/field-type/filedTypeController.js',
            'components/field-type/filedTypeService.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/format-date/formatDate.js',
            'shared/select-level/selectLevelDirective.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/test-field-type.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/test-field-type.js');
    });

    /*genrate script for page test field*/
    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/field/FieldController.js',
            'components/field/FieldService.js',
            'components/field-type/filedTypeService.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/format-date/formatDate.js',
            'shared/select-level/selectLevelDirective.js'
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/testField.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/testField.js');
    });


    /*genrate script for page test-field-type*/
    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/campaign/CampaignService.js',
            'components/campaign/CampaignController.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/campaign-manager.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/campaign-manager.js');
    });


        elixir(function(mix) {
        testFieldTypeScripts = [
            'components/campaign/CampaignDetailService.js',
            'components/campaign/CampaignDetailController.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/campaign-manager-detail.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/campaign-manager-detail.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/role/roleGroupPermissionController.js',
            'components/role/roleGroupService.js',
            'shared/multi-select/multiSelectDirective.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/group-permission.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/group-permission.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'shared/resizer/resizer.js',
            'components/pages-sync/PageSyncService.js',
            'components/pages-sync/PageSyncController.js'
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/page-sync.js', elixir.config.baseJS);
         mix.tripdebug(elixir.config.baseJS+'/pages/page-sync.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/seo/SeoAnalysisService.js',
            'components/seo/SeoAnalysisController.js'
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/seo-analysis.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/seo-analysis.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/seo/pageTraficService.js',
            'components/seo/pageTraficController.js'
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/page-traffic.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/page-traffic.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/pages-sync/pageTraficService.js',
            'components/pages-sync/pageTraficController.js'
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/page-sync-view.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/page-sync-view.js');
    });
    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/terms/termDetailController.js',
            'components/terms/termService.js',
            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/select-level/selectLevelDirective.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/testTerm.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/testTerm.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            // 'app/route.js',
            'components/template-content-manager/templateContentManagerController.js',
            'components/template-content-manager/templateContentManagerService.js',
            'components/template-content-manager/RequestNewTemplateDirective.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',
            'shared/resizer/resizer.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/cms-config-field/ConfigFieldController.js',
            'shared/cms-content/cmsContentFolderService.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/templateContentManager.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/templateContentManager.js');
    });

    elixir(function(mix) {
        editAssetFileTypeScripts = [
            'components/assetmanagers/AssetManagerService.js',
            'components/assetmanagers/EditAssetController.js',
            'shared/resizer/resizer.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/cms-content/cmsContentFolderService.js',
        ];
        mix.scripts(baseScripts.concat(editAssetFileTypeScripts), elixir.config.baseJS+'/pages/edit-asset-file.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/edit-asset-file.js');
    });

    elixir(function(mix) {
        testFieldTypeScripts = [
            'components/tag-content/TagContentService.js',
            'components/tag-content/TagContentController.js',
            'shared/form-builder-directive/formBuilderDirective.js',
        ];
        mix.scripts(baseScripts.concat(testFieldTypeScripts), elixir.config.baseJS+'/pages/tagContent.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/tagContent.js');
    });

    elixir(function(mix) {
        createNewMaterialScripts = [
            'components/materials/MaterialsService.js',
            'components/materials/MaterialsController.js',
            'components/database/selectLevelDirective.js',
            'components/file/fileService.js',
            'shared/file-upload-directive/fileUploadDirective.js'
        ];
        mix.scripts(baseScripts.concat(createNewMaterialScripts), elixir.config.baseJS+'/pages/create-new-material.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/create-new-material.js');
    });

    elixir(function(mix) {
        editMaterialScripts = [
            'components/materials/MaterialsService.js',
            'components/materials/MaterialsController.js',
            'components/database/selectLevelDirective.js',
            'components/file/fileService.js',
            'shared/file-upload-directive/fileUploadDirective.js'
        ];
        mix.scripts(baseScripts.concat(editMaterialScripts), elixir.config.baseJS+'/pages/edit-material.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/edit-material.js');
    });

    elixir(function(mix) {
        translationEditorScripts = [
            'components/pages/EditTranslationController.js',
            'shared/format-date/CheckLimitAndChangeDateTimeDirective.js',
            'components/blocks/partial/EditBlockController.js',
            'components/blocks/BlockManagerService.js',
            'components/pages/EditDraftService.js',
            'components/blocks/partial/InsertBlockLinkAssetController.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/pages/TranslationEditorService.js',
            'components/blocks/nested-block/BlockNestedService.js',
            'components/blocks/nested-block/BlockNestedController.js',

            'shared/form-builder-directive/formBuilderDirective.js',
            'shared/convent-text-to-lowercase/lowercase-character.js',
            'shared/cms-content/cmsContentInsertService.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/modal-select-level/selectLevelDirective.js',
            'shared/modal-select-page/selectLevelDirective.js',
            'shared/select-level-asset/selectLevelDirective.js',
            'shared/remove-cache-front-end/removeCacheService.js',
        ];
        mix.scripts(baseScripts.concat(translationEditorScripts), elixir.config.baseJS+'/pages/translation-editor.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/translation-editor.js');
    });

    elixir(function(mix) {
        translationEditorScripts = [
            'components/pages/PageService.js',
            'components/pages/PageController.js',
            'components/pages/CreatePageController.js',
            'components/pages/CreatePageService.js',
            'components/assetmanagers/AssetManagerService.js',
            'components/assetmanagers/AssetManagerController.js',
            'components/assetmanagers/RequestAssetService.js',
            'components/assetmanagers/RequestAssetController.js',
            'components/assetmanagers/UploadNewAssetDirective.js',
            'components/template-content-manager/templateContentManagerController.js',
            'components/template-content-manager/templateContentManagerService.js',
            'components/template-content-manager/RequestNewTemplateDirective.js',
            'shared/cms/cms-config/CmsConfigController.js',
            'shared/resizer/resizer.js',
            'components/blocks/BlockManagerService.js',

            'components/blocks/BlockManagerController.js',
            'components/blocks/RequestBlockController.js',
            'components/blocks/RequestBlockService.js',
            'components/blocks/partial/EditBlockController.js',
            'components/blocks/RequestNewBlockDirective.js',
            'components/blocks/BlockDirective.js',
            'components/database/DatabaseManagerService.js',
            'components/database/DatabaseManagerController.js',
            'components/file/fileService.js',
            'shared/file-upload/fileTicketUploadDirective.js',

            'shared/tag-content-directive/tagContentDirective.js',
            'components/pages/CreatePageDirective.js',
            'shared/select-level/selectLevelDirective.js',
            'shared/cms-content/cmsContentFolderService.js',
            'components/assetmanagers/RequestNewAssetDirective.js',
            'shared/cms-content/CmsService.js',
            'components/database/selectLevelDirective.js'
        ];
        mix.scripts(baseScripts.concat(translationEditorScripts), elixir.config.baseJS+'/pages/database.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/database.js');
    });

    elixir(function(mix) {
        translationEditorScripts = [
            'components/pages/HistoryService.js',
            'components/pages/HistoryController.js'
        ];
        mix.scripts(baseScripts.concat(translationEditorScripts), elixir.config.baseJS+'/pages/history.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/history.js');
    });

    elixir(function(mix) {
        redirectScripts = [
            'components/pages/RedirectService.js',
            'components/pages/RedirectController.js'
        ];
        mix.scripts(baseScripts.concat(redirectScripts), elixir.config.baseJS+'/pages/redirects.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/redirects.js');
    });

    elixir(function(mix) {
        translationEditorScripts = [
            'components/crop-image/cropImageAssetController.js',
            'shared/rowboat-jcrop/rowboatJcropDirective.js'
        ];
        mix.scripts(baseScripts.concat(translationEditorScripts), elixir.config.baseJS+'/pages/crop.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/crop.js');
    });

    elixir(function(mix) {
        activityLogScript = [
            'components/activity-log/activiLogController.js',
            'components/activity-log/activiLogService.js'
        ];
        mix.scripts(baseScripts.concat(activityLogScript), elixir.config.baseJS+'/pages/activity-log.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/activity-log.js');
    });

    elixir(function(mix) {
        platformScript = [
            'shared/cms-content/CmsService',
            'components/platforms/PlatformsService.js',
            'components/platforms/PlatformsController.js',
            'components/file/fileService.js',
            'shared/file-upload-directive/fileUploadDirective.js'
        ];
        mix.scripts(baseScripts.concat(platformScript), elixir.config.baseJS+'/pages/create-platforms.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/create-platforms.js');
    });
    elixir(function(mix) {
        platformScript = [
            'components/lasers/LaserService.js',
            'components/lasers/LaserController.js'
        ];
        mix.scripts(baseScripts.concat(platformScript), elixir.config.baseJS+'/pages/laser.js', elixir.config.baseJS);
        mix.tripdebug(elixir.config.baseJS+'/pages/laser.js');
    });
    elixir(function(mix) {
        mix.version([
            elixir.config.baseJS+'/pages/page-traffic.js',
            elixir.config.baseJS+'/pages/testTerm.js',
            elixir.config.baseJS+'/pages/page-sync-view.js',
            elixir.config.baseJS+'/pages/seo-analysis.js',
            elixir.config.baseJS+'/pages/asset.js',
            elixir.config.baseJS+'/pages/page-sync.js',
            elixir.config.baseJS+'/pages/campaign-manager.js',
            elixir.config.baseJS+'/pages/campaign-manager-detail.js',
            elixir.config.baseJS+'/pages/group-permission.js',
            elixir.config.baseJS+'/pages/block.js',
            elixir.config.baseJS+'/pages/block-manage.js',
            elixir.config.baseJS+'/pages/editBlock.js',
            elixir.config.baseJS+'/pages/index-block.js',
            elixir.config.baseJS+'/pages/campaign.js',
            elixir.config.baseJS+'/pages/partner.js',
            elixir.config.baseJS+'/pages/language.js',
            elixir.config.baseJS+'/pages/marketsegment.js',
            elixir.config.baseJS+'/pages/page.js',
            elixir.config.baseJS+'/pages/headerDraft.js',
            elixir.config.baseJS+'/pages/edit-draft.js',
            elixir.config.baseJS+'/pages/page-detail.js',
            elixir.config.baseJS+'/pages/page-edit.js',
            elixir.config.baseJS+'/pages/page-create.js',
            elixir.config.baseJS+'/pages/region.js',
            elixir.config.baseJS+'/pages/template.js',
            elixir.config.baseJS+'/pages/templateEdit.js',
            elixir.config.baseJS+'/pages/termTemplate.js',
            elixir.config.baseJS+'/pages/translation.js',
            elixir.config.baseJS+'/pages/dataoption.js',
            elixir.config.baseJS+'/pages/permission.js',
            elixir.config.baseJS+'/pages/role.js',
            elixir.config.baseJS+'/pages/roleEditor.js',
            elixir.config.baseJS+'/pages/roleGroup.js',
            elixir.config.baseJS+'/pages/permissionEditor.js',
            elixir.config.baseJS+'/pages/ticket.js',
            elixir.config.baseJS+'/pages/createticket.js',
            elixir.config.baseJS+'/pages/report.js',
            elixir.config.baseJS+'/pages/viewticket.js',
            elixir.config.baseJS+'/pages/user.js',
            elixir.config.baseJS+'/pages/help-editor.js',
            elixir.config.baseJS+'/pages/create-help-editor.js',
            elixir.config.baseJS+'/pages/permissionforuser.js',
            elixir.config.baseJS+'/pages/profile.js',
            elixir.config.baseJS+'/pages/type.js',
            elixir.config.baseJS+'/pages/home.js',
            elixir.config.baseJS+'/pages/library.js',
            elixir.config.baseJS+'/pages/dashboard.js',
            elixir.config.baseJS+'/pages/versions.js',
            elixir.config.baseJS+'/pages/terms.js',
            elixir.config.baseJS+'/pages/termDetail.js',
            elixir.config.baseJS+'/pages/field.js',
            elixir.config.baseJS+'/pages/testField.js',
            elixir.config.baseJS+'/pages/field-type.js',
            elixir.config.baseJS+'/pages/edit-asset-file.js',
            elixir.config.baseJS+'/pages/test-field-type.js',
            elixir.config.baseJS+'/pages/create-new-material.js',
            elixir.config.baseJS+'/pages/edit-material.js',
            elixir.config.cssOutput+'/all.css',
            elixir.config.baseJS+'/pages/managerTerm.js',
            elixir.config.baseJS+'/pages/templateContentManager.js',
            elixir.config.baseJS+'/pages/tagContent.js',
            elixir.config.baseJS+'/pages/translation-editor.js',
            elixir.config.baseJS+'/pages/database.js',
            elixir.config.baseJS+'/pages/history.js',
            elixir.config.baseJS+'/pages/redirects.js',
            elixir.config.baseJS+'/pages/crop.js',
            elixir.config.baseJS+'/pages/activity-log.js',
            elixir.config.baseJS+'/pages/graphic.js',
            elixir.config.baseJS+'/pages/create-platforms.js',
            elixir.config.baseJS+'/pages/laser.js',
        ]);
    });

});
