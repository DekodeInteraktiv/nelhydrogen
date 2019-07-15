<?php

/**
 * @return ACP\AdminColumnsPro
 */
function ACP() {
	return ACP\AdminColumnsPro::instance();
}

/**
 * Editing instance
 * @since 4.0
 * @return ACP\Editing\Addon
 */
function acp_editing() {
	return ACP()->editing();
}

/**
 * @return ACP\Editing\Helper
 */
function acp_editing_helper() {
	return ACP()->editing()->helper();
}

/**
 * Filtering instance
 * @since 4.0
 * @return ACP\Filtering\Addon
 */
function acp_filtering() {
	return ACP()->filtering();
}

/**
 * @since 4.2
 * @return ACP\Filtering\Helper
 */
function acp_filtering_helper() {
	return ACP()->filtering()->helper();
}

/**
 * Sorting instance
 * @since 4.0
 * @return ACP\Sorting\Addon
 */
function acp_sorting() {
	return ACP()->sorting();
}

/**
 * @return ACP\Export\Addon
 */
function ac_addon_export() {
	return ACP\Export\Addon::instance();
}