<?php
/**
 * 2007-2023 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 * @author Nest Dream
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 */

 if (!defined('_PS_VERSION_')) {
     exit;
 }
 
 class SalesforceChat extends Module
 {
     public function __construct()
     {
         $this->name = 'salesforcechat'; // En minúsculas y sin espacios
         $this->version = '1.0.0';
         $this->author = 'LaqueP';
         $this->tab = 'front_office_features';
         $this->need_instance = 0;
         $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
         $this->bootstrap = true;
 
         parent::__construct();
 
         $this->displayName = $this->l('Multistore module for Salesforce Chat');
         $this->description = $this->l('This module allows you to integrate the Salesforce chat in the footer of each shop in a PrestaShop multistore environment.');
     }
 
     public function install()
     {
         return parent::install() &&
             $this->registerHook('displayFooter') &&
             $this->registerHook('displayHeader') && // Uso correcto del hook
             $this->installTab('AdminParentModulesSf', 'Configuración Salesforce Chat');
     }
 
     public function uninstall()
     {
         return parent::uninstall() && $this->uninstallTab();
     }
 
     public function installTab($parent, $tab_name)
     {
         $tab = new Tab();
         $tab->active = 1;
         $tab->class_name = 'AdminSfChatSettings';
         $tab->name = array_fill_keys(Language::getLanguages(false), $tab_name);
         $tab->id_parent = Tab::getIdFromClassName($parent);
         $tab->module = $this->name;
         return $tab->add();
     }
 
     public function uninstallTab()
     {
         $tab_id = Tab::getIdFromClassName('AdminSfChatSettings');
         if ($tab_id) {
             $tab = new Tab($tab_id);
             return $tab->delete();
         }
         return true;
     }
 
     public function getContent()
     {
         $output = '';
         if (Tools::isSubmit('submitSfChatConfig')) {
             foreach (Shop::getShops() as $shop) {
                 $shopId = $shop['id_shop'];
                 Configuration::updateValue('SF_CHAT_NAME_' . $shopId, Tools::getValue('SF_CHAT_NAME_' . $shopId));
                 Configuration::updateValue('SF_CHAT_SHOP_' . $shopId, Tools::getValue('SF_CHAT_SHOP_' . $shopId));
                 Configuration::updateValue('SF_CHAT_SALESFORCE_DOMAIN_' . $shopId, Tools::getValue('SF_CHAT_SALESFORCE_DOMAIN_' . $shopId));
                 Configuration::updateValue('SF_CHAT_SECURE_DOMAIN_' . $shopId, Tools::getValue('SF_CHAT_SECURE_DOMAIN_' . $shopId));
                 Configuration::updateValue('SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $shopId, Tools::getValue('SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $shopId));
                 Configuration::updateValue('SF_CHAT_LIVE_AGENT_BASE_URL_' . $shopId, Tools::getValue('SF_CHAT_LIVE_AGENT_BASE_URL_' . $shopId));
                 Configuration::updateValue('SF_CHAT_EMBEDDED_SERVICE_URL_' . $shopId, Tools::getValue('SF_CHAT_EMBEDDED_SERVICE_URL_' . $shopId));
                 Configuration::updateValue('SF_CHAT_DEPLOYMENT_ID_' . $shopId, Tools::getValue('SF_CHAT_DEPLOYMENT_ID_' . $shopId));
                 Configuration::updateValue('SF_CHAT_BUTTON_ID_' . $shopId, Tools::getValue('SF_CHAT_BUTTON_ID_' . $shopId));
                 Configuration::updateValue('SF_CHAT_ORGANIZATION_ID_' . $shopId, Tools::getValue('SF_CHAT_ORGANIZATION_ID_' . $shopId));
             }
             $output .= $this->displayConfirmation($this->l('Configuración actualizada.'));
         }
         return $output . $this->renderForm();
     }
     public function renderForm()
     {
         $formFields = [];
         $currentShopId = Shop::getContextShopID(); // Obtener el ID de la tienda actual en el contexto
     
         if ($currentShopId) {
             $shop = new Shop($currentShopId);

                     // Campo para seleccionar la tienda
        $formFields[] = [
            'type' => 'text',
            'label' => $this->l('Seleccione la tienda para el chat ') . $shop->name,
            'name' => 'SF_CHAT_SHOP_' . $currentShopId,
            'required' => true,
            'desc' => $this->l('Selecciona la tienda en la que se configura el chat de Salesforce.'),            
        ];

        // Campo para sf_chat_name
        $formFields[] = [
            'type' => 'text',
            'label' => $this->l('Nombre único del chat en Salesforce'),
            'name' => 'SF_CHAT_NAME_' . $currentShopId,
            'required' => true,
            'desc' => $this->l('Nombre único para la configuración del chat en Salesforce.'),
        ];
     
             // Campo para el dominio de Salesforce
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Dominio de Salesforce'),
                 'name' => 'SF_CHAT_SALESFORCE_DOMAIN_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('Dominio principal de Salesforce utilizado para cargar el chat.'),
             ];
     
             // Campo para el Secure Domain de Live Agent
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Secure Domain de Live Agent'),
                 'name' => 'SF_CHAT_SECURE_DOMAIN_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('Secure Domain para la conexión segura de Live Agent.'),
             ];
     
             // Otros campos necesarios para configuración del chat...
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('LiveAgent Content URL'),
                 'name' => 'SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('URL de contenido de LiveAgent de Salesforce.'),
             ];
     
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('LiveAgent Base URL'),
                 'name' => 'SF_CHAT_LIVE_AGENT_BASE_URL_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('URL base de LiveAgent de Salesforce para la conexión de chat.'),
             ];
     
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Embedded Service URL'),
                 'name' => 'SF_CHAT_EMBEDDED_SERVICE_URL_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('URL del servicio embebido de Salesforce.'),
             ];
     
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Deployment ID'),
                 'name' => 'SF_CHAT_DEPLOYMENT_ID_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('ID de despliegue de Salesforce para el chat.'),
             ];
     
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Button ID'),
                 'name' => 'SF_CHAT_BUTTON_ID_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('ID del botón de Salesforce para iniciar el chat.'),
             ];
     
             $formFields[] = [
                 'type' => 'text',
                 'label' => $this->l('Organization ID'),
                 'name' => 'SF_CHAT_ORGANIZATION_ID_' . $currentShopId,
                 'required' => true,
                 'desc' => $this->l('ID de la organización de Salesforce.'),
             ];
         } else {
             $formFields[] = [
                 'type' => 'html',
                 'html_content' => '<p>' . $this->l('Seleccione una tienda específica en el entorno de multitienda para configurar los campos.') . '</p>'
             ];
         }
     
         $helper = new HelperForm();
         $helper->module = $this;
         $helper->submit_action = 'submitSfChatConfig';
         $helper->fields_value = $this->getFormValues();
     
         return $helper->generateForm([['form' => ['input' => $formFields, 'submit' => ['title' => $this->l('Guardar')]]]]);
     }

     public function getFormValues()
     {
         $values = [];
         foreach (Shop::getShops() as $shop) {
             $shopId = $shop['id_shop'];
             $values['SF_CHAT_NAME_' . $shopId] = Configuration::get('SF_CHAT_NAME_' . $shopId);
             $values['SF_CHAT_SHOP_' . $shopId] = Configuration::get('SF_CHAT_SHOP_' . $shopId);
             $values['SF_CHAT_SALESFORCE_DOMAIN_' . $shopId] = Configuration::get('SF_CHAT_SALESFORCE_DOMAIN_' . $shopId);
             $values['SF_CHAT_SECURE_DOMAIN_' . $shopId] = Configuration::get('SF_CHAT_SECURE_DOMAIN_' . $shopId);
             $values['SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $shopId] = Configuration::get('SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $shopId);
             $values['SF_CHAT_LIVE_AGENT_BASE_URL_' . $shopId] = Configuration::get('SF_CHAT_LIVE_AGENT_BASE_URL_' . $shopId);
             $values['SF_CHAT_EMBEDDED_SERVICE_URL_' . $shopId] = Configuration::get('SF_CHAT_EMBEDDED_SERVICE_URL_' . $shopId);
             $values['SF_CHAT_DEPLOYMENT_ID_' . $shopId] = Configuration::get('SF_CHAT_DEPLOYMENT_ID_' . $shopId);
             $values['SF_CHAT_BUTTON_ID_' . $shopId] = Configuration::get('SF_CHAT_BUTTON_ID_' . $shopId);
             $values['SF_CHAT_ORGANIZATION_ID_' . $shopId] = Configuration::get('SF_CHAT_ORGANIZATION_ID_' . $shopId);
         }
         return $values;
     }
         
public function hookDisplayFooter($params)
{
    $shopId = $this->context->shop->id;

    $this->context->smarty->assign([
        'sf_chat_lang' => $this->context->language->iso_code,
        'sf_chat_domain' => $this->context->shop->domain,
        'sf_chat_shop' => Configuration::get('SF_CHAT_SHOP_' . $shopId),
        'sf_chat_name' => Configuration::get('SF_CHAT_NAME_' . $shopId),
        'defaultMinimizedText' => $this->l('¿Necesitas ayuda?'),
        'loadingText' =>  $this->l('Cargando...'),
        'offlineSupportMinimizedText' => $this->l('Contactar'),
        'sf_chat_salesforce_domain' => Configuration::get('SF_CHAT_SALESFORCE_DOMAIN_' . $shopId),
        'sf_chat_secure_domain' => Configuration::get('SF_CHAT_SECURE_DOMAIN_' . $shopId),
        'sf_chat_live_agent_content_url' => Configuration::get('SF_CHAT_LIVE_AGENT_CONTENT_URL_' . $shopId),
        'sf_chat_live_agent_base_url' => Configuration::get('SF_CHAT_LIVE_AGENT_BASE_URL_' . $shopId),
        'sf_chat_embedded_service_url' => Configuration::get('SF_CHAT_EMBEDDED_SERVICE_URL_' . $shopId),
        'deploymentId' => Configuration::get('SF_CHAT_DEPLOYMENT_ID_' . $shopId),
        'buttonId' => Configuration::get('SF_CHAT_BUTTON_ID_' . $shopId),
        'organizationId' => Configuration::get('SF_CHAT_ORGANIZATION_ID_' . $shopId),
    ]);

    return $this->display(__FILE__, 'views/templates/hook/displayFooter.tpl');
}

     

     public function hookDisplayHeader()
     {
         return $this->display(__FILE__, 'views/templates/hook/displayHeader.tpl');
     }     
 } 