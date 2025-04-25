{*
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
    * @ author Nest Dream
    * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
    * versions in the future. If you wish to customize PrestaShop for your
    * needs please refer to https://devdocs.prestashop.com/ for more information.
*}
<script type='text/javascript' src='{$sf_chat_embedded_service_url}'></script>

<script type='text/javascript'>
    var initESW = function(gslbBaseURL) {
        embedded_svc.settings.displayHelpButton = true;
        embedded_svc.settings.language = "{$sf_chat_lang}";

        embedded_svc.settings.defaultMinimizedText = "{$defaultMinimizedText}";
        embedded_svc.settings.loadingText = "{$loadingText}";
        embedded_svc.settings.storageDomain = "{$sf_chat_domain}";
        embedded_svc.settings.offlineSupportMinimizedText = "{$offlineSupportMinimizedText}";

        embedded_svc.settings.extraPrechatFormDetails = [
            {
                "label": "Tienda",
                "value": "{$sf_chat_shop}",
                "displayToAgent": true,
                "transcriptFields": ["Tienda__c"]
            },
            {
                "label": "Idioma",
                "value": "{$sf_chat_lang}",
                "displayToAgent": true,
                "transcriptFields": ["Idioma__c"]
            }
        ];

            embedded_svc.settings.extraPrechatInfo = [{
                "entityFieldMaps": [{
                  "doCreate": false,
                  "doFind": false,
                  "fieldName": "LastName",
                  "isExactMatch": true,
                  "label": "Apellidos"
                }, {
                  "doCreate": false,
                  "doFind": false,
                  "fieldName": "FirstName",
                  "isExactMatch": true,
                  "label": "Nombre"
                }, {
                  "doCreate": false,
                  "doFind": true,
                  "fieldName": "Email",
                  "isExactMatch": true,
                  "label": "Correo electrónico"
                }, {
                  "doCreate": false,
                  "doFind": false,
                  "fieldName": "Phone",
                  "isExactMatch": true,
                  "label": "Teléfono móvil"
                  }],
                "entityName": "Contact",
              }];
        embedded_svc.settings.enabledFeatures = ['LiveAgent'];
        embedded_svc.settings.entryFeature = 'LiveAgent';

        embedded_svc.init(
            '{$sf_chat_salesforce_domain}',
                  '{$sf_chat_secure_domain}',
                gslbBaseURL,
            '{$organizationId}',
            '{$sf_chat_name}',
            {
                baseLiveAgentContentURL: '{$sf_chat_live_agent_content_url}',
                deploymentId: '{$deploymentId}',
                buttonId: '{$buttonId}',
                baseLiveAgentURL: '{$sf_chat_live_agent_base_url}',
                eswLiveAgentDevName: '{$sf_chat_name}',
                isOfflineSupportEnabled: false
            }
        );
    };

    if (!window.embedded_svc) {
        var s = document.createElement('script');
        s.setAttribute('src', '{$sf_chat_embedded_service_url}');
        s.onload = function() {
            initESW(null);
        };
        document.body.appendChild(s);
    } else {
        initESW('https://service.force.com');
    }
</script>
