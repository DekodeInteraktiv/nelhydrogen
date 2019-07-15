<?php

class WPML_WPSEO_Main_Factory implements IWPML_Backend_Action_Loader, IWPML_Frontend_Action_Loader {
	public function create() {
		global $sitepress, $wpml_url_converter, $pagenow;

		$canonicals = new WPML_Canonicals( $sitepress, new WPML_Translation_Element_Factory( $sitepress ) );

		$hooks                = array();
		$hooks['xml-sitemap'] = new WPML_WPSEO_XML_Sitemaps_Filter( $sitepress, $wpml_url_converter );
		$hooks['filters']     = new WPML_WPSEO_Filters( $canonicals );
		$hooks['metabox']     = new WPML_WPSEO_Metabox_Hooks( new WPML_Debug_BackTrace( phpversion() ), $wpml_url_converter, $pagenow );
		$hooks['categories']  = new WPML_WPSEO_Categories();

		return $hooks;

	}
}
