<?php

namespace mvBilligerTracking;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use mvSliderBox\Bootstrap\EmotionElementInstaller;

class mvBilligerTracking extends Plugin
{
    public function install(InstallContext $installContext)
    {

    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $deactivateContext)
    {
        $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        $uninstallContext->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
    }

    // Events abonnieren.
    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PreDispatch' => 'addTemplateDir',			//Template Verzeichnis hinzufügen.
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatch',		//Plugin Einstellungen im Template zur Verfügung stellen.
        );
    }

    // Template Verzeichnis hinzufügen!

    public function addTemplateDir(\Enlight_Event_EventArgs $args) {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir(
            $this->getPath() . '/Resources/views/'
        );

        //$view->extendsTemplate('backend/mv_custom_top_bar/app.js');
    }


    // Plugin Einstellungen im Template zur Verfügung stellen.

    public function onPostDispatch(\Enlight_Event_EventArgs $args) {
        $shop = false;

        if ($this->container->initialized('shop')) {
            $shop = $this->container->get('shop');
         }

        if (!$shop) {
            $shop = $this->container->get('models')->getRepository(\Shopware\Models\Shop\Shop::class)->getActiveDefault();
        }

        $pluginConfig = Shopware()->Container()->get('shopware.plugin.cached_config_reader')->getByPluginName('mvBilligerTracking', $shop);

        $controller = $args->getSubject();
        $view = $controller->View();

        $view->assign('mv_billiger_tracking_settings', $pluginConfig);
    }
}