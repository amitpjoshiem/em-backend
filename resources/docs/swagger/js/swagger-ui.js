import SwaggerUIBundle from 'swagger-ui'

window.addEventListener('load', async () => {

    const url = document.getElementById('swagger-ui').dataset.source;

    window.ui = SwaggerUIBundle({
        url,
        dom_id: '#swagger-ui',
        deepLinking: true,
        docExpansion: 'list',
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIBundle.SwaggerUIStandalonePreset,
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
    });
});

