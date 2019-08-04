"use strict";

/**
 * This is global file and will be included by /webpack/demos/{demo}/script.js
 */

// Keentheme"s plugins
window.KTUtil = require("../../resources/assets/src/js/theme/core/util");
window.KTApp = require("../../resources/assets/src/js/theme/core/app");
window.KTAvatar = require("../../resources/assets/src/js/theme/core/base/avatar");
window.KTDialog = require("../../resources/assets/src/js/theme/core/base/dialog");
window.KTHeader = require("../../resources/assets/src/js/theme/core/base/header");
window.KTMenu = require("../../resources/assets/src/js/theme/core/base/menu");
window.KTOffcanvas = require("../../resources/assets/src/js/theme/core/base/offcanvas");
window.KTPortlet = require("../../resources/assets/src/js/theme/core/base/portlet");
window.KTScrolltop = require("../../resources/assets/src/js/theme/core/base/scrolltop");
window.KTToggle = require("../../resources/assets/src/js/theme/core/base/toggle");
window.KTWizard = require("../../resources/assets/src/js/theme/core/base/wizard");
require("../../resources/assets/src/js/theme/core/base/datatable/core.datatable");
require("../../resources/assets/src/js/theme/core/base/datatable/datatable.checkbox");
require("../../resources/assets/src/js/theme/core/base/datatable/datatable.rtl");

// Layout scripts
require("../../resources/assets/src/js/theme/core/layout/demo-panel");
require("../../resources/assets/src/js/theme/core/layout/offcanvas-panel");
require("../../resources/assets/src/js/theme/core/layout/quick-panel");
require("../../resources/assets/src/js/theme/core/layout/quick-search");
window.KTLib = require("../../resources/assets/src/js/theme/core/lib");
