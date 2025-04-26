# Salesforce Chat Multistore - PrestaShop Module

Este módulo permite integrar el **chat de Salesforce** en el footer de cada tienda en un entorno multitienda de PrestaShop. Además, facilita la personalización de las configuraciones específicas por tienda, incluyendo la posibilidad de añadir estilos CSS personalizados desde el backoffice.

## Características

- Integración del chat de **Salesforce Live Agent** por tienda en multitienda.
- Configuración de:
  - **Dominio de Salesforce**.
  - **Secure Domain**.
  - **Deployment ID** y **Button ID**.
  - **Organization ID**.
  - **Embedded Service URL**.
  - **Campos transcript personalizados** para Tienda e Idioma.
- Textos predeterminados traducibles desde el sistema de traducciones de PrestaShop.
- **CSS personalizado configurable** por tienda desde el backoffice.
- Compatible con **PrestaShop 1.7 y 8.x**.

## Instalación

1. **Sube el módulo**:
   - Copia la carpeta del módulo en `/modules/salesforcechat/`.
   
2. **Instálalo desde el backoffice**:
   - Ve a **Módulos > Módulos y servicios**.
   - Busca **Salesforce Chat Multistore** y haz clic en **Instalar**.

3. **Configura las opciones**:
   - Una vez instalado, accede a la configuración del módulo.
   - Selecciona cada tienda en el entorno multitienda y completa los datos específicos de Salesforce.

## Configuración

### Por tienda puedes configurar:

- **Dominio de Salesforce**.
- **Secure Domain** para cargar los scripts de Salesforce.
- **Deployment ID** y **Button ID**.
- **Organization ID**.
- **Embedded Service URL**.
- **Campos transcript** para Tienda e Idioma (nombre del campo en Salesforce).
- **CSS personalizado** para adaptar el estilo del chat.

Los textos del chat (como **"Need help?"**, **"Loading"**, **"Contact Us"**) se traducen automáticamente desde el sistema de traducciones de PrestaShop.

## Estructura del módulo

salesforcechat/ ├── config/ ├── controllers/ ├── views/ │ ├── css/ │ │ └── custom_style_{id_shop}.css # Archivo CSS generado automáticamente por tienda │ └── templates/ │ └── hook/ │ ├── displayHeader.tpl │ └── displayFooter.tpl ├── salesforcechat.php └── README.md

## Recomendaciones

- Asegúrate de tener correctamente configurados los **IDs de Salesforce** para cada tienda.
- Puedes personalizar el aspecto del botón del chat añadiendo CSS en el campo de **CSS personalizado**.
