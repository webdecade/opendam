<?php
// auto-generated by sfDefineEnvironmentConfigHandler
// date: 2014/10/20 15:01:51
sfConfig::add(array(
  'app_zip_convert_iso_8859_1' => true,
  'app_ch_cms_expose_routing_register_scripts' => true,
  'app_ch_cms_expose_routing_register_routes' => true,
  'app_ch_cms_expose_routing_auto_discover' => true,
  'app_ch_cms_expose_routing_params_blacklist' => array (
  0 => 'module',
  1 => 'action',
),
  'app_max_per_page' => 20,
  'app_languages_available' => array (
  0 => 'fr',
  1 => 'en',
),
  'app_path_upload_dir' => '/var/www/opendam/web/data',
  'app_path_upload_dir_name' => 'data',
  'app_path_temp_dir' => '/var/www/opendam/web/tmp',
  'app_path_temp_dir_name' => 'tmp',
  'app_path_images_dir' => '/var/www/opendam/web/images',
  'app_path_images_dir_name' => 'images',
  'app_path_css_dir' => '/var/www/opendam/web/css',
  'app_path_css_dir_name' => 'css',
  'app_path_js_dir' => '/var/www/opendam/web/js',
  'app_path_js_dir_name' => 'js',
  'app_path_flash_dir' => '/var/www/opendam/web/flah',
  'app_path_flash_dir_name' => 'flash',
  'app_path_temp_dir_js' => '/var/www/opendam/web/data/tmp_files',
  'app_path_temp_dir_js_name' => 'tmp_files',
  'app_path_qrcode_dir' => '/var/www/opendam/web/data/qrcode',
  'app_path_qrcode_dir_name' => 'data/qrcode',
  'app_path_download_dir' => '/var/www/opendam/web/download',
  'app_path_download_dir_name' => 'download',
  'app_facebox_iframe_sizes' => array (
  0 => 650,
  1 => 750,
  2 => 900,
),
  'app_facebox_650_pages' => array (
  0 => 'folder/comment',
  1 => 'file/sendFileForm',
  2 => 'file/move',
  3 => 'file/copy',
  4 => 'file/delete',
  5 => 'folder/move',
  6 => 'folder/delete',
  7 => 'group/merge',
  8 => 'file/moveSelected',
  9 => 'file/copySelected',
  10 => 'file/deleteSelected',
  11 => 'folder/addFolderUpload',
  12 => 'group/step1',
  13 => 'group/merge',
  14 => 'map/nomap',
  15 => 'group/remove',
  16 => 'file/regenerateThumbnails',
),
  'app_facebox_750_pages' => array (
  0 => 'folder/accessRights',
  1 => 'folder/inviteUsers',
  2 => 'folder/importUsers',
),
  'app_facebox_900_pages' => array (
  0 => 'group/manageUsers',
  1 => 'group/accessRight',
  2 => 'group/inviteUsers',
  3 => 'group/importUsers',
  4 => 'group/constraint',
  5 => 'group/tags',
  6 => 'folder/edit',
  7 => 'folder/thumbnail',
  8 => 'folder/default',
  9 => 'file/replace',
  10 => 'upload/uploadify2',
  11 => 'group/fields',
  12 => 'group/step1',
  13 => 'group/thumbnail',
  14 => 'group/require',
),
  'app_imagemagick_profile_rgb' => '/var/www/opendam/inc/sRGB.icc',
  'app_search_empty_media' => 'keyword:none',
  'app_search_not_filename' => '-filename',
  'app_assetic_active' => false,
  'app_assetic_yui_path' => '/var/www/opendam/lib/yuicompressor-2.4.7.jar',
  'app_assetic_js' => array (
  'path' => 'main-prod.js',
  'files' => 
  array (
    0 => 'jquery/jquery-2.0.3.min.js',
    1 => 'jquery/jquery-migrate-1.2.1.min.js',
    2 => 'jquery/jquery-ui.min.js',
    3 => 'facebox.min.js',
    4 => 'tools.js',
    5 => 'plugins.min.js',
    6 => 'basket.min.js',
    7 => 'jquery.editable.min.js',
    8 => 'jquery.datepicker.fr.min.js',
    9 => 'jquery.datepicker.en.min.js',
    10 => 'jquery.simplePagination.js',
    11 => 'modules/global/scroll.js',
  ),
),
  'app_assetic_css' => array (
  'path' => 'main-prod.css',
  'files' => 
  array (
    0 => 'app.css',
    1 => 'style.css',
    2 => 'font-awesome.min.css',
    3 => 'jquery-ui-1.7.1.custom.css',
    4 => 'module/user/login.css',
    5 => 'module/user/password.css',
  ),
),
  'app_wpI18n_use_cache' => false,
  'app_wpLess_use_cache' => false,
  'app_wpLess_minify' => false,
  'app_all_module_on_admin' => false,
  'app_sf_less_plugin_check_dates' => true,
  'app_sf_less_plugin_check_dependencies' => true,
));
