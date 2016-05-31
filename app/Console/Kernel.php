<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\getStorageAsset::class,
        \App\Console\Commands\ImportUlsFromOldDb::class,
        \App\Console\Commands\CronJobSyncPages::class,
        \App\Console\Commands\changeTimerTicket::class,
        \App\Console\Commands\Blocks\AddManageBlock::class,
        
        \App\Console\Commands\Assets\AddAssetFolderType::class,
        \App\Console\Commands\Page\RemoveFieldsInvaldInPage::class,
        \App\Console\Commands\Page\RemoveFieldsInvaldInContentPage::class,
        \App\Console\Commands\Database\AddValueDemo::class,
        \App\Console\Commands\Database\ImportPlatform::class,
        \App\Console\Commands\Database\ImportLaser::class,
        \App\Console\Commands\Database\ImportPlatformLaser::class,
        \App\Console\Commands\Database\AddAvailableLaserPowers::class,
        \App\Console\Commands\CreateTicketChildPage::class,
        //permission
        \App\Console\Commands\Permission\AddPermissionActivityLog::class,
        \App\Console\Commands\Permission\AddPermissionHelpEditor::class,
        \App\Console\Commands\Permission\AddPermissionDeleteTicket::class,
        \App\Console\Commands\Permission\AddPermissionDocumentManagement::class,
        \App\Console\Commands\Permission\AddEditFileAsset::class,
        \App\Console\Commands\Permission\AddPermissionAdvancedEditingFeatures::class,
        \App\Console\Commands\Permission\insertPermissionInsertPage::class,
        \App\Console\Commands\Permission\InsertSysAdmin::class,
        \App\Console\Commands\Permission\SetPermissionTypeTicketForUser::class,
        \App\Console\Commands\Permission\SetPermissionTypeUpdatePageTicketForUser::class,
        \App\Console\Commands\Permission\AddPermissionManageRedirects::class,

        \App\Console\Commands\DataOption\AddNewDataOption::class,
        \App\Console\Commands\Pages\CreateSearchPage::class,
        \App\Console\Commands\Pages\AddSearchInPageLive::class,
        \App\Console\Commands\Pages\DeleteSearchPage::class,
        \App\Console\Commands\Pages\UpdateIndexDataMultiPages::class,
        
        \App\Console\Commands\CmsContent\AddPropertiesAncestorIdsForItem::class,
        \App\Console\Commands\CmsContent\AddPropertiesAncestorIdsForFolder::class,
        \App\Console\Commands\CmsContent\AddRootFolder::class,

        \App\Console\Commands\Types\AddColumnParentToTypeTable::class,
        \App\Console\Commands\Types\AddTypeChildsTemplate::class,
        \App\Console\Commands\Types\AddTicketTypeCreateNewBlock::class,
        \App\Console\Commands\Types\AddTypePlatformIssuesRequests::class,
        \App\Console\Commands\Types\AddTicketTypeCreateNewAsset::class,
        \App\Console\Commands\Types\AddTicketTypeCreateNewPage::class,
        \App\Console\Commands\Types\AddTicketTypePageRevision::class,
        \App\Console\Commands\Types\AddTicketTypeRequestRegion::class,
        \App\Console\Commands\Types\AddTicketTypeRequestTranslation::class,
        \App\Console\Commands\Types\AddTicketTypeTemplate::class,
        \App\Console\Commands\Types\AddTicketTypeUpdatePage::class,
        \App\Console\Commands\Types\AddTypeChannelPartnerUpdate::class,
        \App\Console\Commands\Types\AddTypeDatabaseUpdate::class,
        \App\Console\Commands\Types\AddTypeFileUpload::class,
        \App\Console\Commands\Types\AddTypePageBuild::class,
        \App\Console\Commands\Types\AddTypeTicketChild::class,
        \App\Console\Commands\Types\LegacyCreateNewPage::class,
        \App\Console\Commands\Types\LegacyUpdatePage::class,

        \App\Console\Commands\Materials\DeleteMaterialAndContentAndCategory::class,
        \App\Console\Commands\Materials\AddNewDataMaterual::class,
        \App\Console\Commands\Materials\AddDataCategory::class,

        //release version
        \App\Console\Commands\ReleaseVersion\CreateDefaultReleaseVersion::class,
        //pages
        \App\Console\Commands\Dashboard\CreateNewDashboardUser::class,

        // User
        \App\Console\Commands\Users\AddSortNumberFieldForHelpEditor::class,


        \App\Console\Commands\Run\RunCommand::class,
        \App\Console\Commands\ImportAsseccories::class,
        \App\Console\Commands\Custom\GenerateComponent::class,
        \App\Console\Commands\Database\ImportAccessories::class,
        \App\Console\Commands\Database\ConverCharSpecial::class,
        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     \DB::table('test')->delete();
        // })->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('cronjob:sync_seo_pages')->dailyAt('00:00');
    }
}
