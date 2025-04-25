# salesforcechat
Module multi-store of prestashop for embed the salesforce Chat

# Compatibilidad

PHP >= 7.4
PRestashop >= 1.7

# Modificación de Estilos

// El módulo incorpora estilos por defecto y incluye una variable que puede configurar en su fichero principal de css

Puede modificar el css del embed del chat en el siguiente fichero:

**salesforcechat/views/css/style.css**

Las variable del boton configurable:

**(--chat__button)**

# Formulario y mensajes predefinidos

El sistema de integración del formulario, tiene por defecto 4 valores, debera modificarlos con los campos configurados en su Sistema integrado en Salesforce o adaptar su sismte integrado a los campos incluidos en el módulo:

**salesforcechat/views/templates/hook/displayFooter.tpl**

Campos del formulario:

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



