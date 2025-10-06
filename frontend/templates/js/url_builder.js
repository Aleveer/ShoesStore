/**
 * Generate a URL for API calls or page navigation
 * @param {Object} options - URL configuration options
 * @param {string} options.module - The module name
 * @param {string} [options.view] - The view name (for dashboard module)
 * @param {string} [options.action] - The action name (for non-dashboard modules)
 * @param {Object} [options.params] - Additional query parameters
 * @param {boolean} [options.isApi] - Whether this is an API call (affects base path)
 * @returns {string} - The formatted URL
 */

function generateUrl(options) {
    // Get the current path to determine if we're in a subdirectory
    const currentPath = window.location.pathname;
    const pathParts = currentPath.split('/').filter(part => part !== '');

    // Find the base path (look for 'frontend' in the path)
    let basePath = '/';
    const frontendIndex = pathParts.indexOf('frontend');
    if (frontendIndex > 0) {
        basePath = '/' + pathParts.slice(0, frontendIndex).join('/') + '/';
    }

    const baseUrl = window.location.origin + basePath + 'frontend/';
    const path = options.module === 'dashboard' ? 'index.php?' : '?';

    let url = baseUrl + path + 'module=' + options.module;

    if (options.module === 'dashboard' && options.view) {
        url += '&view=' + options.view;
    } else if (options.action) {
        url += '&action=' + options.action;
    }

    if (options.params) {
        Object.keys(options.params).forEach(key => {
            if (options.params[key] !== null && options.params[key] !== undefined) {
                url += '&' + encodeURIComponent(key) + '=' + encodeURIComponent(options.params[key]);
            }
        });
    }

    return url;
}

// /**
//  * Generate API endpoint URL
//  * @param {string} endpoint - The API endpoint path
//  * @param {Object} [params] - Query parameters
//  * @returns {string} - The formatted API URL
//  */
// function generateApiUrl(endpoint, params = {}) {
//     const currentPath = window.location.pathname;
//     const pathParts = currentPath.split('/').filter(part => part !== '');

//     let basePath = '/';
//     const frontendIndex = pathParts.indexOf('frontend');
//     if (frontendIndex > 0) {
//         basePath = '/' + pathParts.slice(0, frontendIndex).join('/') + '/';
//     }

//     let url = window.location.origin + basePath + 'backend/' + endpoint;

//     if (Object.keys(params).length > 0) {
//         const queryString = Object.keys(params)
//             .filter(key => params[key] !== null && params[key] !== undefined)
//             .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key]))
//             .join('&');
//         url += '?' + queryString;
//     }

//     return url;
// }

/**
 * Navigate to a specific module/view
 * @param {Object} options - Navigation options (same as generateUrl)
 */
function navigateTo(options) {
    window.location.href = generateUrl(options);
}

/**
 * Open URL in new tab
 * @param {Object} options - Navigation options (same as generateUrl)
 */
function openInNewTab(options) {
    window.open(generateUrl(options), '_blank');
}