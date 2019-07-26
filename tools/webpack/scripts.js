"use strict";

/**
 * This is global file and will be included by /webpack/demos/{demo}/script.js
 */

// Keentheme"s plugins
window.KTUtil = require("../../assets/src/assets/js/theme/core/util");
window.KTApp = require("../../assets/src/assets/js/theme/core/app");
window.KTAvatar = require("../../assets/src/assets/js/theme/core/base/avatar");
window.KTDialog = require("../../assets/src/assets/js/theme/core/base/dialog");
window.KTHeader = require("../../assets/src/assets/js/theme/core/base/header");
window.KTMenu = require("../../assets/src/assets/js/theme/core/base/menu");
window.KTOffcanvas = require("../../assets/src/assets/js/theme/core/base/offcanvas");
window.KTPortlet = require("../../assets/src/assets/js/theme/core/base/portlet");
window.KTScrolltop = require("../../assets/src/assets/js/theme/core/base/scrolltop");
window.KTToggle = require("../../assets/src/assets/js/theme/core/base/toggle");
window.KTWizard = require("../../assets/src/assets/js/theme/core/base/wizard");
require("../../assets/src/assets/js/theme/core/base/datatable/core.datatable");
require("../../assets/src/assets/js/theme/core/base/datatable/datatable.checkbox");
require("../../assets/src/assets/js/theme/core/base/datatable/datatable.rtl");

// Layout scripts
require("../../assets/src/assets/js/theme/core/layout/demo-panel");
require("../../assets/src/assets/js/theme/core/layout/offcanvas-panel");
require("../../assets/src/assets/js/theme/core/layout/quick-panel");
require("../../assets/src/assets/js/theme/core/layout/quick-search");
window.KTLib = require("../../assets/src/assets/js/theme/core/lib");
